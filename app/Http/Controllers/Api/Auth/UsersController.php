<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Http\Requests\administrator\StoreUserRequest;
use App\Http\Requests\administrator\UpdateUserRequest;
use App\Models\Division;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->select(
            'users.*',
            'user_details.*',
            'divisions.division_code',
            'divisions.division_name'
            )->where('users.user_type', '!=', true)->orderBy('user_details.nama_depan', 'ASC')->get();
        return view('user.userIndex', compact('user'));
    }

    public function create()
    {
        $division = Division::all();
        $adv = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->select(
            'users.*',
            'user_details.*',
            'divisions.division_code',
            'divisions.division_name'
            )->where('divisions.division_code', 'ADV4256')->orderBy('user_details.nama_depan', 'ASC')->get();
        return view('user.userCreate', compact('division', 'adv'));
    }

    public function store(StoreUserRequest $request)
    {
        $filename = '';

        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->nama_depan) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/user', $filename);
        }

        $user = User::create([
            'division_id'   => $request->division_id,
            'parent_id'     => $request->parent_id != '' ? $request->parent_id : null,
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        UserDetail::create([
            'user_id'       => $user->id,
            'nama_depan'    => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'image'         => $filename != ''  ? $filename : null,
            'alamat'        => $request->alamat,
            'phone'         => $request->phone,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_masuk' => $request->tanggal_masuk
        ]);

        UserActivityHelper::addToLog(auth()->user()->username. ' add new user');

        return redirect(route('user-index'))->with(['success' => 'User Baru Ditambahkan']);
    }

    public function edit($id)
    {
        $user = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->select(
            'users.*',
            'user_details.*',
            'divisions.division_code',
            'divisions.division_name'
            )->where('users.id', $id)->first();
        $division = Division::all();
        $adv = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
        ->select(
            'users.*',
            'user_details.*',
            'divisions.division_code',
            'divisions.division_name'
            )->where('divisions.division_code', 'ADV4256')->orderBy('user_details.nama_depan', 'ASC')->get();
        return view('user.userEdit', compact('user', 'division', 'adv'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $detail = UserDetail::where('user_id', $id)->first();
        $file = $detail->image;
        if ($request->hasFile('image') != '') {
            File::delete(storage_path('app/public/user/' . $file));
            $file = $request->file('image')->store('public/user');
        }

        $user->update([
            'division_id'   => $request->division_id,
            'parent_id'     => $request->parent_id,
            'status'        => $request->status,
        ]);
        $detail->update([
            'user_id'        => $user->id,
            'nama_depan'     => $request->nama_depan,
            'nama_belakang'  => $request->nama_belakang,
            'image'          => $file,
            'alamat'         => $request->alamat,
            'phone'          => $request->phone,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        return redirect(route('user-index'))->with(['success' => 'User Diedit Ditambahkan']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $detai = UserDetail::where('user_id', $id)->first();
        File::delete(storage_path('app/public/user/' . $detai->image));
        $user->delete();
        $detai->delete();

        UserActivityHelper::addToLog(auth()->user()->username. ' delete user');

        return back();
    }

    public function userImage($filename)
    {
        $path = storage_path('app/public/user/'.$filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
