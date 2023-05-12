<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Events\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function message()
    {
        event(new Message(request()->username, request()->message));

        return ['status' => 'Success'];
    }
}
