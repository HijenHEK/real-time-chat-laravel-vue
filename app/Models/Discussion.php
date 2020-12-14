<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class Discussion extends Model
{
    use HasFactory;
    
    protected $fillable=['name'];
    protected $appends =['unreadCount'];
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('contact');
    }

    static function Common(User $user , User $u = null){
        if(!$u) { $u = Auth::user(); }
        return $user->discussions()->whereIn('id' , $u->discussions())->get() ;
    }

    public function  getUnreadCountAttribute(){
        return $this->messages->map->viewedBy(Auth::user())->countBy()->get(0) ;
    }
}
