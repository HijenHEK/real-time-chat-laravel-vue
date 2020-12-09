<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function store($discussion) {
        Request()->validate([
            'content' => 'required'
        ]);
        Message::create([
            "sender"=> Auth::id(),
            "discussion_id"=> $discussion,
            "content"=> Request("sender")
        ]);
        
    }
}
