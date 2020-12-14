<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
    public function views(){
        return $this->belongsToMany(User::class , 'views' , 'message_id' , 'user_id' ) ;
    }
    public function viewedBy(User $user){
        return View::where('message_id' , $this->id)->where('user_id' , $user->id )->exists();
    }
    public function viewed(){
        return $this->views()->where('user_id' , '<>' , Auth::id())->exists(); 
    }
}
