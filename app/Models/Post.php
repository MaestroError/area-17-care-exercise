<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $author_id
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Post extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_active',
        'published_at',
        'author_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'author_id' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['author'];

    /**
     * Relationships
     */

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Methods
     */

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function isPublished(): bool
    {
        return $this->published_at <= Carbon::now();
    }

    public function isPublic(): bool
    {
        return $this->isActive() && $this->isPublished();
    }

    /**
     * Attributes
     */

    /**
     * @param $attribute
     * @return string
     */
    public function getTitleAttribute($attribute): string
    {
        return Str::title($attribute);
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getBodyAttribute($attribute): string
    {
        return nl2br($attribute);
    }

    /**
     * Scopes
     */

    /**
     * Scopes
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', Carbon::now());
    }

    /**
     * Scopes
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scopes
     * @param Builder $query
     * @return Builder
     */
    public function scopeDisplayable(Builder $query): Builder
    {
        return $query->published()->active();
    }

    /**
     * Scopes
     * @param Builder $query
     * @return Builder
     */
    public function scopeFromAuthor(Builder $query): Builder
    {
        return $query->where('author_id', Auth::id());
    }

    /**
     * Spatie Sluggable
     */

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(60);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
