<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Models\UserActivity;

class UserActivityController extends Controller
{
    public function __construct()
    {
        /* log user activity */
    }

    public function testLog()
    {
        UserActivityHelper::addToLog('testing');
        dd('log insert success');
    }

    public function userActivity()
    {
        $logs = UserActivityHelper::userActivityLists();
        return view('userActivity', compact('logs'));
    }
}
