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
        return User::all()->except(Auth::id());
    }
}
