<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    protected $appends = ['username'];

    protected $hidden = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function getUsernameAttribute()
    {
        return $this->user->username;
    }

    protected $table = 'comment';
}
