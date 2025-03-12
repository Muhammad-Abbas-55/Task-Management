<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'image_path',
        'user_id ',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
