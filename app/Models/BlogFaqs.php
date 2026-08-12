<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogFaqs extends Model
{
    protected $table = 'blog_faq';
    protected $fillable = [
        'blog_id',
        'question',
        'answer'
    ];
   public  function blog(){
        return $this->belongsTo(Blogs::class);
    }
}
