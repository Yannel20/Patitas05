<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'receiver_id', 'body', 'file_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::disk('ccs')->url($this->file_path) : null;
    }

     
}
