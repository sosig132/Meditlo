<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';
    protected $fillable = ['user_id', 'phone', 'user_photo', 'about_me', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProfile($userId)
    {
        return self::where('user_id', $userId)->first();
    }

    public static function updateProfile($data, $userId)
    {
        $profile = self::firstOrNew(['user_id' => $userId]);

        $profile->fill($data);

        return $profile->save();
    }
}
