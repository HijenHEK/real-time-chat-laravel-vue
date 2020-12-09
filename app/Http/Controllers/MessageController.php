<?php

namespace App\Http\Controllers;

use App\Events\Update;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //


    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store($id) {
        Request()->validate([
            'content' => 'required'
        ]);
        Message::create([
            "user_id"=> Auth::id(),
            "discussion_id"=> $id,
            "content"=> Request("content")
        ]);
        event(new Update());

    }
}
