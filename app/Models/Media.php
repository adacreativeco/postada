<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'thumb_path',
        'disk',
        'mime_type',
        'size',
        'alt_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return \Storage::disk($this->disk)->url($this->path);
    }

    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getIsVideoAttribute()
    {
        return str_starts_with($this->mime_type, 'video/');
    }
}
