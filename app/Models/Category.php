<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'description', 'image'
    ];

    // protected $guarded = [];

    // Global Scope => except for all select statement
    protected static function booted()
    {
        static::addGlobalScope('main_category', function (Builder $builder) {
            // $builder->leftJoin('categories.parent_id');    
        });

        static::forceDeleted(function($category){
            if ($category->image){
                Storage::disk('public')->delete($category->image);
            }
        });

        static::saving(function($category){
            $category->slug = Str::slug($category->name);
        });
    }

    public function scopeSearch(EloquentBuilder $builder, $value)
    {
        if ($value) {
            $builder->where('categories.name', 'LIKE', "%$value%");
        }
    }
}
