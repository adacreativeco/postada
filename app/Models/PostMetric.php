<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMetric extends Model
{
    protected $fillable = [
        'post_id',
        'platform',
        'metric_name',
        'metric_value',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
