<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->where('status', true)->where('user_type', false)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'failed', 'message' => 'User login failed.'], 401);
        }

        $success['token']    =  $user->createToken(time())->plainTextToken;
        $success['username'] =  $user->username;

        return response()->json(['status' => 'success', 'data' => $success, 'message' => 'User login successfully.'], 200);
    }

    public function userLogin(Request $request)
    {
        $user = $request->user()->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->select(
            'users.email', 'users.username',
            'user_details.nama_depan', 'user_details.nama_belakang', 'user_details.image',
            'divisions.division_code',
            'divisions.division_name'
            )->where('divisions.division_code', 'ADV4256')->orderBy('user_details.nama_depan', 'ASC')->first();
        return response()->json(['status' => 'success', 'data' => $user, 'message' => 'User login successfully.'], 200);
    }

    public function userImage($filename)
    {
        $path = storage_path('app/public/user/'.$filename);

        if (!file_exists($path)) {
            return response()->json(['status' => 'success', 'message' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $path, 'message' => 'User login successfully.'], 200);
    }

    public function logout()
    {
        // auth()->user()->currentAccessToken()->delete();
    }
}
