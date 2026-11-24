<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blogs extends Model
{
    use hasFactory,SoftDeletes;
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'category',
        'tags',
        'excerpt',
        'content',
        'feature_image_alt',
        'feature_image',
        'meta_title',
        'keywords',
        'meta_description',
        'schema',
        'status',
        'published_at',
        'created_by'
    ];

protected static function booted(): void
{
    // A post switched on without a date goes live immediately.
    static::saving(function (Blogs $blog) {
        if ($blog->status && ! $blog->published_at) {
            $blog->published_at = now();
        }
    });

    // Let the sitemap pick up new and edited posts.
    static::saved(fn () => Cache::forget('sitemap_xml'));
    static::deleted(fn () => Cache::forget('sitemap_xml'));
}

/**
 * Posts visitors may see: switched on and their publish time has passed.
 */
public function scopePublished(Builder $query): Builder
{
    return $query->where('status', true)
        ->where(function (Builder $q) {
            $q->whereNull('published_at')->orWhere('published_at', '<=', now());
        });
}

public function isScheduled(): bool
{
    return (bool) $this->status && $this->published_at && $this->published_at->isFuture();
}
protected function casts(): array
{
    return [
        'tags' => 'array',
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];
}
public function faq(){
    return $this->hasMany(BlogFaqs::class,'blog_id','id');
}
public function admin(){
    return $this->belongsTo(Admin::class,'created_by','id');
}
public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category', 'id');
    }
}
