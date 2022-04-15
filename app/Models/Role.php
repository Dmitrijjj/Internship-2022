<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';

    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_MODERATOR,
        self::ROLE_ADMIN,

    ];
}
