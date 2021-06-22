<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Post as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Post extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;

    protected $fillable = [
        'CreatorId',
        'OwnerId',
        'Text',
    ];
}
