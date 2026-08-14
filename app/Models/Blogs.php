<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'created_by'
        
    ];

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
