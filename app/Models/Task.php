<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in progress';
    public const STATUS_UNDER_REVIEW = 'under review';
    public const STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_UNDER_REVIEW,
        self::STATUS_COMPLETED
    ];

    protected $fillable = ['name', 'description', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
