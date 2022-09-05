<?php

namespace App\Http\Controllers\administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserActivity as UserActivityHelper;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = UserActivityHelper::userActivityLists();
        return view('dashboard', compact('logs'));
    }
}
