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
        if($this->source == 'youtube') {
          
            return 'https://img.youtube.com/vi/' . $this->getYoutubeIdFromUrl($this->uri) . '/hqdefault.jpg';
        }
    }

    public function getVideoIdAttribute()
    {
        if ($this->source == 'youtube') {
            return $this->getYoutubeIdFromUrl($this->uri);
        }
        return null;
    }

    private function getYoutubeIdFromUrl($url)
    {
        $queryParams = [];
        parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
        return $queryParams['v'] ?? null;
    }
    public function getUriAttribute($value)
    {
        if ($this->source == 'youtube') {
            return $value;
        } elseif ($this->source == 'cloud') {
            return $value;
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

    public static function addVideo($data) {
        $content = new self();
        $content->user_id = $data['user_id'];
        $content->title = $data['title'];
        $content->description = $data['description'];
        $content->type = 'video';
        $content->uri = $data['video_url'];
        $content->thumbnail = $data['thumbnail'] ? $data['thumbnail'] : null;
        $content->source = $data['source'];
        $content->save();
        if (isset($data['selectedCategories']) && is_array($data['selectedCategories'])) {
            $content->addCategories($data['selectedCategories']);
        }
        return $content;
    }

    public static function addDocument($data) {
        $content = new self();
        $content->user_id = $data['user_id'];
        $content->title = $data['title'];
        $content->description = $data['description'];
        $content->type = 'document';
        $content->uri = $data['document_url'];
        $content->source = 'local';
        $content->save();
        if (isset($data['selectedCategories']) && is_array($data['selectedCategories'])) {
            $content->addCategories($data['selectedCategories']);
        }
        return $content;
    }

    public function updateContent($data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->save();
        
        return $this;
    }

    public function getCategories()
    {
        return $this->categories()->get();
    }

}
