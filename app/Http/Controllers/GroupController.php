<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        try {
            
            $groups = Group::all();

            return response()->json([
                'success' => true,
                'message' => 'Listado de los grupos',
                'data' => $groups
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un problema al listar los grupos ...',
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            
            $group = new Group();
            $group->name = $request->get('name');
            $response = $group->save();
            if ($response) {
                return response()->json([
                    'success' => true,
                    'message' => 'El grupo se registro con éxito ...',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrio un problema al registrar un grupo ...',
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
