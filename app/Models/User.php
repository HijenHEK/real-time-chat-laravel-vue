<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKey()
    {
        return 'uname' ;
    }



    public function sentMessages(){
        return $this->hasMany(Message::class );
    }
    
    
    public function discussions(){
        return $this->belongsToMany(Discussion::class);
    }


    public function friends() {
        $one = DB::table('friends')->join('users',  'friends.user_id', '=', 'users.id')
                            ->select('users.*')
                            ->where('friends.user_id', Auth::id())
                            ->where('users.id' ,'<>' , Auth::id())
                            ->get();

        return DB::table('friends')->join('users',  'friends.user_id', '=', 'users.id')
                        ->select('users.*')
                        ->where('friends.friend_id', Auth::id())
                        ->where('users.id' ,'<>' , Auth::id())
                        ->union($one)
                        ->get();
        // select * from friends f , users u where f.user_id = 11  
        // and f.user_id = u.id
        // and u.id <> 11 
        // UNION select * from friends f , users u where f.friend_id = 11 and f.user_id = u.id and u.id <> 11
    }
}
