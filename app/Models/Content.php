<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'content';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'uri',
        'thumbnail',
        'source'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return null;
    }
    public function getUriAttribute($value)
    {
        if ($this->source == 'youtube') {
            return $value;
        } elseif ($this->source == 'cloud') {
            //TODO add cloud storage url + make bunny.net cdn work
            return '';
        } elseif ($this->source == 'local') {
            return asset($value);
        }
        return null;
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'content_category', 'content_id', 'category_id');
    }
    public function addCategories($categoryIds)
    {
        return $this->categories()->sync($categoryIds);
    }
}
