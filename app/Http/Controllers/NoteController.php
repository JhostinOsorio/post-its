<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\NotifyCallReceived;
use App\Models\Note;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        try {
            
            $startDate = $request->get('startDate');
            $enddate = $request->get('endDate');
            $withImage = $request->get('withImage') === 'true' ? true : false;

            $notes = [];
            
            if ($startDate && $enddate && $withImage) {
                $notes = Note::where('path_image', '<>', 'NULL')
                                ->whereBetween('created_at', [$startDate, $enddate])->get();
            } else if ($startDate && $enddate) {
                $notes = Note::whereBetween('created_at', [$startDate, $enddate])->get();
            } else {
                $notes = Note::all();
            }

            return response()->json([
                'success' => true,
                'message' => 'Listado de las notas',
                'data' => $notes
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un problema al listar las notas ...',
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            if (!auth()->user()->group_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Para registrar una nota, debes unirte a un grupo',
                ], 403);
            }
            $note = new Note();
            $note->user_id = auth()->user()->id;
            $note->title = $request->get('title');
            $note->description = $request->get('description');
            $filename = $request->get('filename');
            $imgBase64 = $request->get('imgBase64');
            if ($imgBase64 && $filename) {
                Storage::disk('public')->put($filename, base64_decode($imgBase64));
                $note->filename = $filename;
                $note->path_image = Storage::url($filename);
            }
            $response = $note->save();
            if ($response) {
                return $this->sendEmail($note);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrio un problema al registrar una nota ...',
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $noteId = $request->get('noteId');
            $imgBase64 = $request->get('imgBase64');
            $filename = $request->get('filename');
            Storage::disk('public')->put($filename, base64_decode($imgBase64));
            $note = Note::findOrFail($noteId);
            $note->filename = $filename;
            $note->path_image = Storage::url($filename);
            $response = $note->save();
            if ($response) {
                return response()->json([
                    'success' => true,
                    'message' => 'Se subio la imágen con éxito ...',
                    'data' => [
                        'path_image' => Storage::url($filename)
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrio un problema al subir la imágen ...',
                ], 200);
            }
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'La nota a la que desea añadir una imágen, no existe',
                ], 404);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function sendEmail(Note $note)
    {
        try {
            $groupId = auth()->user()->group_id;
            $users = User::where('group_id', $groupId)->get();
            foreach ($users as $user) {
                dispatch(new SendEmailJob($user, $note));
            }
            return response()->json([
                'success' => true,
                'message' => 'La nota se registro con éxito ...',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'La nota se registro con éxito, pero ocurrio un error al momento de enviar los correos ' . $e->getMessage(),
            ], 500);
        }
    }
}
