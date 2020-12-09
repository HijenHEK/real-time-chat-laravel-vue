<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return Auth::user()->discussions()->with(['users' => function($query){
            $query->where('user_id' ,'<>' , Auth::id());
        },'messages'=> function($query){
            $query->orderBy('created_at' , 'desc');
        }
        ])->latest()->get();
    }

    public function show(Discussion $discussion) {
        return $discussion->messages()->with('user')->latest()->get();
    }
}
