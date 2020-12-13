<?php

namespace App\Models\Traits;

use App\Models\Discussion;
use App\Models\Message;
use App\Models\User;

trait Discussionable
{
    public function sentMessages(){
        return $this->hasMany(Message::class );
    }
    
    
    public function discussions(){
        return $this->belongsToMany(Discussion::class)->withPivot('contact');;
    }

    public function hasDiscussion(User $user){
        return $this->discussions->map->users->collapse()->contains('id',$user->id);
    }


    public function viewed(){
        return $this->belongsToMany(Message::class , 'views' , 'user_id'  , 'message_id' ) ;
    }
}
