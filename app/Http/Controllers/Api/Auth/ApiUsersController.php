<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\StoreUsersRequest;
use Illuminate\Http\Request;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Http\Requests\Api\Auth\UpdateUsersRequest;
use App\Http\Resources\UsersCollection;
use App\Models\Division;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ApiUsersController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.*',
                'user_details.*',
                'divisions.division_code',
                'divisions.division_name'
            )->where('users.user_type', '!=', true)->orderBy('user_details.nama_depan', 'ASC');
        if (request()->search != null) {
            $users = $users->where('nama_depan', 'LIKE', '%' . request()->search . '%');
        }
        $users = $users->get();
        $data = [];
        foreach ($users as $row) {
            $data[] = [
                'username' => $row->username,
                'nama' => $row->nama_depan . " " . $row->nama_belakang,
                'email' => $row->email,
                'phone' => $row->phone,
                'image' => Storage::disk('public')->url('user/' . $row->image),
                'division' => $row->division_name,
            ];
        }
        return new UsersCollection($data);
    }

    public function show($username)
    {
        $user = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.*',
                'user_details.*',
                'divisions.division_code',
                'divisions.division_name'
            )->where('users.username', $username)->first();
        $data = "";
        if ($user->parent_id != null) {
            $adv = UserDetail::where('user_id', $user->parent_id)->first();
        }
        $data = [
            'adv' => $user->parent_id != null ? $adv->nama_depan . " " . $adv->nama_belakang : null,
            'username' => $user->username,
            'nama' => $user->nama_depan . " " . $user->nama_belakang,
            'alamat' => $user->alamat,
            'phone' => $user->phone,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'tanggal_masuk' => $user->tanggal_masuk,
            'image' => Storage::disk('public')->url('user/' . $user->image),
            'gender' => $user->jenis_kelamin,
            'division' => $user->division_name,
        ];
        return response()->json(['status' => 'success', 'data' => $data], 200);
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

    public function store(StoreUsersRequest $request)
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

        UserActivityHelper::addToLog(auth()->user()->username . ' add new user');

        return redirect(route('user-index'))->with(['success' => 'User Baru Ditambahkan']);
    }

    public function edit($username)
    {
        $edit = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select(
                'users.email',
                'users.username',
                'users.status',
                'users.parent_id',
                'users.division_id',
                'user_details.*',
            )->where('users.username', $username)->first();
        return response()->json(['status' => 'success', 'data' => $edit, 'message' => 'Data load successfully.'], 200);
    }

    public function profileUpdate(Request $request)
    {
        // $info = Log::debug([
        //     'username'   => $request->username,
        //     'email'     => $request->email,
        //     'nama_depan'     => $request->nama_depan,
        //     'nama_belakang'  => $request->nama_belakang,
        //     'alamat'         => $request->alamat,
        //     'phone'          => $request->phone,
        //     'tanggal_lahir'  => $request->tanggal_lahir,
        // ]);
        $id = request()->user();
        $user = User::find($id->id);
        $this->validate($request, [
            'username'    => ['required', Rule::unique('users')->ignore($user)],
            'email'       => ['required', Rule::unique('users')->ignore($user)],
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:500000',
            'alamat'        => 'nullable',
            'phone'         => 'nullable',
            'tanggal_lahir' => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            $detail = UserDetail::where('user_id', $user->id)->first();
            $filename = $detail->image;
            if ($request->hasFile('image') != '') {
                $file = $request->file('image');
                File::delete(storage_path('app/public/user/' . $filename));
                $filename = time() . Str::slug($request->nama_depan) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/user', $filename);
            }

            $user->update([
                'username'   => $request->username,
                'email'     => $request->email,
            ]);
            $detail->update([
                'user_id'        => $user->id,
                'nama_depan'     => $request->nama_depan,
                'nama_belakang'  => $request->nama_belakang,
                'image'          => $filename,
                'alamat'         => $request->alamat,
                'phone'          => $request->phone,
                'tanggal_lahir'  => $request->tanggal_lahir,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $detai = UserDetail::where('user_id', $id)->first();
        File::delete(storage_path('app/public/user/' . $detai->image));
        $user->delete();
        $detai->delete();

        UserActivityHelper::addToLog(auth()->user()->username . ' delete user');

        return back();
    }

    public function getAdv()
    {
        $adv = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.id',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'divisions.division_code'
            )->where('divisions.division_code', 'ADV4256')->orderBy('user_details.nama_depan', 'ASC')->get();

        return response()->json(['status' => 'success', 'data' => $adv, 'message' => 'Data load successfully.'], 200);
    }

    public function userImage($filename)
    {
        $path = storage_path('app/public/user/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function getCS()
    {
        $cs = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.*',
                'user_details.*',
                'divisions.division_code',
                'divisions.division_name'
            )->where('divisions.division_code', 'CUS9178')->orWhere('divisions.division_code', 'CMP3651')->orWhere('divisions.division_code', 'CSL7901')->orderBy('user_details.nama_depan', 'ASC')->get();

        return response()->json(['status' => 'success', 'data' => $cs, 'message' => 'Data load successfully.'], 200);
    }

    public function listAllUser()
    {
        $users = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.*',
                'user_details.*',
                'divisions.division_code',
                'divisions.division_name'
            )->where('users.user_type', '!=', true)
            ->orderBy('users.status', 'DESC')
            ->orderBy('user_details.nama_depan', 'ASC');
        if (request()->search != null) {
            $users = $users->where('nama_depan', 'LIKE', '%' . request()->search . '%');
        }
        $users = $users->get();
        $data = [];
        foreach ($users as $row) {
            $data[] = [
                'username' => $row->username,
                'nama' => $row->nama_depan . " " . $row->nama_belakang,
                'email' => $row->email,
                'phone' => $row->phone,
                'image' => Storage::disk('public')->url('user/' . $row->image),
                'division' => $row->division_name,
                'status'   => $row->status,
            ];
        }

        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }
}
