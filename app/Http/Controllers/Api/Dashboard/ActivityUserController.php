<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserDetail;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function userActivityDetail($id)
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));
        $user = UserDetail::where('user_id', $id)->first();
        $activity = UserActivity::where('user_id', $id)
                    ->where(DB::raw("(STR_TO_DATE(date_time, '%Y-%m-%d'))"), 'LIKE', '%' . $filter . '%')
                    ->get();
        $data = [];
        $newDates = [];
        $method = "";
        foreach ($activity as $row) {
            $dataTime = DateTime::createFromFormat('Y-m-d H:i:s', $row->date_time);
            switch ($row->method) {
                case 'POST':
                    $method = $user->nama_depan . " Menambahkan";
                    break;
                case 'DELETE':
                    $method = $user->nama_depan . " Menghapus";
                    break;
                default:
                    $method = "";
                    break;
            }
            $newDates[$dataTime->format('Y-m-d')][] = [
                'time' => $dataTime->format('H:i:s'),
                'method' => $method,
                'activity' => $row->activity,
            ];
        }
        // foreach ($array_date as $row) {
        //     $f_date = strlen($row) == 1 ? 0 . $row : $row;
        //     $date = $filter . '-' . $f_date;
        //     $d = $a->firstWhere('date', $date);
        //     $data[] = [
        //         'date' => $date,
        //         'total' => $d,
        //     ];
        // }
        return response()->json(['status' => 'success', 'data' => $newDates, 'message' => 'Data load successfully.'], 200);
    }
}
