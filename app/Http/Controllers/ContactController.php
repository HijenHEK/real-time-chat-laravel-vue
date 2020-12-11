<?php

namespace App\Http\Controllers;

use App\Events\Update;
use App\Models\Discussion;
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

    public function store(User $user = null , Discussion $discussion = null ,Request $r) {


        if($this->isContact($user)){
            return response( "$user is already a contact" , 406 );
        } else
        if($this->isRequestOut($user)){
            return response( "request already sent !" , 406 );
        } else
        if ($this->is($user)) {
            return response( 'you cant add yourself' , 406 );

        } else {
        
            if($user) {
                Auth::user()->addContact($user) ;
                $user->discussions()->updateExistingPivot($discussion->id ,['contact' => true   ]);
                Auth::user()->discussions()->updateExistingPivot($discussion->id ,['contact' => true   ]);
                event(new Update());

            }else{
                
                $this->validate($r, [
                    'uname' => 'required|exists:users,uname'
                ]);
                $user = User::where('uname' , $r->uname)->first();
                
                Auth::user()->addContact($user) ;

                if(!Auth::user()->discussions->map->users->collapse()->where('id',$user->id)){
                    $d = Auth::user()->discussions()->create();
                    $d->users()->attach($user , ['contact' => Auth::user()->iscontact($user)]);
                }

                event(new Update());
                    
                return response('success' , 200);    
            }
        }
    
    }
    public function destroy(User $user){
        if(Auth::user()->isRequestOut($user) || Auth::user()->isrequestIn($user)){
            Auth::user()->removeContact($user) ;
        }else {

            return response('unAuthorized' , 406);
        }
        event(new Update());

    }

}
