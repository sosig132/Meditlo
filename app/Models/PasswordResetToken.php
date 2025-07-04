<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $fillable = ['email', 'token', 'created_at'];
    public $timestamps = false; // Since this table typically doesn't have `updated_at`
}
