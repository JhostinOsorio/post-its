<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $response = $user->save();
            if ($response) {
                return response()->json([
                    'success' => true,
                    'message' => 'El usuario se registro con éxito ...',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrio un problema al registrar un usuario ...',
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function assignGroup(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $groupId = $request->get('groupId');
            $user = User::find($userId);
            $user->group_id = $groupId;
            $user->save();
            return $user;
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
