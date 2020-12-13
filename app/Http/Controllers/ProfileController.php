<?php

namespace App\Http\Controllers;

use App\Events\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function index(){
        return view('profile');
    }
    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'uname' => 'required|max:255|unique:users,uname,'.Auth::id(),
            'email' => 'required|max:255|unique:users,email,'.Auth::id(),
            'avatar' => 'file',
            'password' => 'required|min:8|max:255'
        ]);

        
        if(! Hash::check($request->password, Auth::user()->password)){
            return response('wrong password' , 406);
        }
        
        Auth::user()->name = $request->name ;
        Auth::user()->uname = $request->uname ;
        Auth::user()->email = $request->email ;
        if($request->file('avatar')) {
            $av = $request->file('avatar')->store('avatars' , ['disk'=>'public']);
            Auth::user()->avatar = $av;
        }
        if($request->pass) {
            $request->validate([
                'new_password' => 'confirmed'
            ]);
            Auth::user()->password = Hash::make($request->new_password);
        }
        Auth::user()->save();
        event(new Update());

        return back()->with('message' , 'profile updated successfully');

    }
}
