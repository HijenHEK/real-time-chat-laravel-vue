<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sender() {
        return $this->belongsTo(User::class , 'sender');
    }
    public function recepient() {
        return $this->belongsTo(User::class , 'recepient');
    }
    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }
}
