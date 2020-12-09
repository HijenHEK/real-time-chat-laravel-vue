<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function store($user) {
        Request()->validate([
            'content' => 'required'
        ]);
        Message::create([
            "sender"=> Auth::id(),
            "recepient"=> $user,
            "content"=> Request("sender")
        ]);
        
    }
}
