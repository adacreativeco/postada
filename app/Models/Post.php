<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'team_id',
        'content',
        'platforms',
        'media_ids',
        'status',
        'scheduled_at',
        'published_at',
    ];

    protected $casts = [
        'platforms' => 'array',
        'media_ids' => 'array',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(PostMetric::class);
    }

    public function getMediaAttribute()
    {
        if (empty($this->media_ids)) {
            return collect();
        }
        return Media::whereIn('id', $this->media_ids)->get();
    }

    public static function loadMediaFor($posts)
    {
        if (empty($posts)) {
            return $posts;
        }

        $allMediaIds = collect($posts)->pluck('media_ids')->flatten()->filter()->unique()->values();
        if ($allMediaIds->isEmpty()) {
            foreach ($posts as $post) {
                if (is_object($post) && method_exists($post, 'setRelation')) {
                    $post->setRelation('media', collect());
                }
            }
            return $posts;
        }

        $mediaItems = Media::whereIn('id', $allMediaIds)->get()->keyBy('id');

        foreach ($posts as $post) {
            if (is_object($post) && method_exists($post, 'setRelation')) {
                $postMedia = collect($post->media_ids ?? [])->map(fn($id) => $mediaItems->get($id))->filter()->values();
                $post->setRelation('media', $postMedia);
            }
        }

        return $posts;
    }
}
