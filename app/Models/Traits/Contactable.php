<?php

namespace App\Models\Traits;

use App\Models\User;

trait Contactable
{
    public function requestsOut() {
        return $this->belongsToMany(User::class , 'contacts' , 'user_id' , 'contact_id');
    }
    public function waitingRequestsOut(){
        return $this->requestsOut()->whereNotIn('user_id' , $this->requestsIn()->pluck('contact_id')) ;
    }
    public function waitingRequestsIn(){
        return $this->requestsIn()->whereNotIn('user_id' , $this->requestsOut()->pluck('contact_id')) ;
    }
    public function requestsIn() {
        return $this->belongsToMany(User::class , 'contacts' , 'contact_id' ,  'user_id');
    }
    public function contacts() {
        return $this->requestsIn()->whereIn('user_id' , $this->requestsOut()->pluck('contact_id'));
    }
    public function addContact(User $user) {
        
            $this->requestsOut()->attach($user);
            if($this->isRequestOut($user)) {
                return response("request sent to $user->uname " , 200);
    
            }else {
                return response("$user->name is in your contact now !" , 200);
    
            }
    }
    public function removeContact(User $user) {
        $this->requestsOut()->detach($user);
        $this->requestsIn()->detach($user);
    }
    public function deleteContact(User $user) {
        $this->requestsOut()->detach($user);
        $this->requestsIn()->detach($user);
        
    }
    
    public function isContact(User $user){
        return $this->contacts->contains($user);
    }
    public function isRequestOut(User $user){
        return $this->requestsOut->contains($user);
    }
    public function isRequestIn(User $user){
        return $this->requestsIn->contains($user);
    }
}
