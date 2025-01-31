<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable = [
        'caption',
        'image',
        'user_id',
    ];

    protected $appends = ['username'];

    protected $hidden = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsernameAttribute()
    {
        return $this->user->username;
    }

    protected $table = 'forum';
}