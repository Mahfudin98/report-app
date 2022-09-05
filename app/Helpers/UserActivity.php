<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\UserActivity as UserActivityModel;
use Carbon\Carbon;

class UserActivity
{
    public static function addToLog($activity)
    {
        $time = Carbon::now();
        $log = [];
        $log['date_time'] = $time->toDateTime();
        $log['activity'] = $activity;
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['browser'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : null;
        UserActivityModel::create($log);
    }

    public static function userActivityLists()
    {
        return UserActivityModel::latest()->get();
    }
}
