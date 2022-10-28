<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityUserController extends Controller
{
    public function userActivity($username)
    {
        $user = User::where('username', $username)->first();

        if (request()->date != '') {
            $date = Carbon::parse(request()->date)->format('d');
        } else {
            $date = Carbon::today()->format('d');
        }

        $activity = UserActivity::where('user_id', $user->id)->whereDay('date_time', '=', $date)->orderBy('date_time', 'DESC')->get();
        $data = [];
        $method = "";
        foreach ($activity as $row) {
            switch ($row->method) {
                case 'POST':
                    $method = $user->username . " Menambahkan";
                    break;
                case 'DELETE':
                    $method = $user->username . " Menghapus";
                    break;
                default:
                    $method = "";
                    break;
            }
            $data[] = [
                'method' => $method,
                'date' => $row->date_time,
                'activity' => $row->activity,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }
}
