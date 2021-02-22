<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Book extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isExist($categoryId, $authorId, $title)
    {
        return $this->where('category_id', $categoryId)->where('author_id', $authorId)->where('title', $title)->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
