<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'culture',
        'approved',
    ];

    protected $casts = [
        'rating'   => 'integer',
        'approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved', true);
    }

    public static function averageRating(): float
    {
        return round((float) (self::approved()->avg('rating') ?? 0), 1);
    }

    public static function totalApproved(): int
    {
        return self::approved()->count();
    }

    public static function ratingDistribution(): array
    {
        $dist = [];
        for ($i = 5; $i >= 1; $i--) {
            $dist[$i] = self::approved()->where('rating', $i)->count();
        }
        return $dist;
    }

    public static function hasReviewed(int $userId): bool
    {
        return self::where('user_id', $userId)->exists();
    }

    public static function findByUser(int $userId): ?self
    {
        return self::where('user_id', $userId)->first();
    }

    public function getInitialsAttribute(): string
    {
        if (!$this->user) return '??';
        return collect(explode(' ', trim($this->user->name)))
            ->filter()
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)
            ->implode('');
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}