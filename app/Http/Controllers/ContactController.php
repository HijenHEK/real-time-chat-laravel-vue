<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return Auth::user()->contacts();
    }
    public function store(Request $r) {
        
        $this->validate($r, [
            'uname' => 'required|exists:users,uname'
        ]);
        $user = User::where('uname' , $r->uname)->first();

        return Auth::user()->addContact($user) ;

        // return response('success' , 200);

    
    }
}
