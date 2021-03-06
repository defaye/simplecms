<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'published',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        // 'tags',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->title);
        });

        parent::boot();
    }

    /**
     * Get all of the images for the post.
     */
    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable')->withPivot('position')->orderBy('position');
    }

    /**
     * Get the category this post belongs to.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get all of the tags of this post.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * Get all of the pages of this post.
     */
    public function pages()
    {
        return $this->belongsToMany('App\Page')->withPivot('order');
    }
}
