<?php

namespace App\Http\Controllers;

use App\Events\Update;
use App\Events\ViewDiscussion;
use App\Models\Contact;
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
            $query->where('user_id' ,'<>' , Auth::id())->with(['requestsOut'=> function($query){
                $query->where('contact_id' , Auth::id())->exists() ;
            } , 'requestsIn'=> function($query){
                $query->where('user_id' , Auth::id())->exists() ;
            }  ]);
        },'messages'=> function($query){
            $query->orderBy('created_at' , 'desc');
        } 
        ])->latest()->get() ;
    }

    public function show(Request $r ,Discussion $discussion) {

        if($r->view === "true"){

            foreach($discussion->messages()->get() as $message){
                if(!$message->views->contains(Auth::user())) {
                    $message->views()->attach(Auth::user()) ;
                    event(new Update());
    
                }
            } 
    
        }
        
  



        return $discussion->messages()->with(['user','views' => function($query){
            $query->where('user_id' , '<>' , Auth::id());
        }])->latest()->paginate(20);

        
        // return $discussion->messages()->with(['user','views'])->latest()->get();
    }

    // public function store(Request $r) {

        
    //     $this->validate($r, [
    //         'uname' => 'required|exists:users,uname'
    //     ]);
            
    //     $user = User::where('uname' , $r->uname)->first();
    //     if(Auth::user()->is($user)) {
    //         return response('you cannot dm yourself' , '422');
 
    //     }
    //     if(Auth::user()->hasDiscussion($user)) {
    //         return response('discussions exists already' , '422');
    //     }
    //     $d = Auth::user()->discussions()->create();
    //     $d->users()->attach($user , ['contact' , Auth::user()->iscontact($user)]);
    //     event(new Update());
    //     return response('success' , 200);

        
    // }
}
