<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $auth = $request->except(['remember_me']);
        $user = User::where('username', $request->username)->where('status', true)->where('user_type', false)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'failed', 'message' => 'User login failed.'], 401);
        }
        $token = $user->createToken(time())->plainTextToken;
        return response()->json(['status' => 'success', 'data' => $token, 'message' => 'User login successfully.'], 200);
    }

    public function userLogin()
    {
        $user = request()->user();
        $login = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.id',
                'users.email',
                'users.username',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.image',
                'user_details.alamat',
                'user_details.tanggal_lahir',
                'user_details.phone',
                'divisions.division_code',
                'divisions.division_name'
            )->where('users.id', $user->id)->first();
        return response()->json(['status' => 'success', 'data' => $login, 'message' => 'User login successfully.'], 200);
    }

    public function userImage()
    {
        $user = request()->user();
        $image = UserDetail::where('user_id', $user->id)->first();
        $path = Storage::disk('public')->url('user/' . $image->image);

        if ($image->image == null) {
            return response()->json(['status' => 'failed', 'message' => 'User login failed.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $path, 'message' => 'Image Load success.'], 200);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
    }
}
