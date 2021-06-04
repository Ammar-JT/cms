<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    //This tells laravel 'treat this as date', to be specific, it tells the Model class that
    //.. so we can use do the comparison for published_at and copare it with the date() down there in scopePublished:
    protected $dates = [
        'published_at'
    ];

    protected $fillable = [
        'title', 'description','content','image','published_at', 'category_id', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function deleteImage(){
        $currentPath = getcwd();

        //I used unlink instead of storage cuz storage won't work in hostgator!
        unlink($currentPath .'/storage/'. $this->image);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tagId){
        //هدا اللاين والله يدرررس
        //pluck will give you the array of id's instead of the whole tag:
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }

//---------------------------------------------------------------------------------------------
//                              Query Local Scopes
//---------------------------------------------------------------------------------------------
    public function scopeSearched($query){
        $search = request()->query('search');

        if(!$search){
            return $query->published();
        }

        return $query->published()->where('title', 'LIKE', "%{$search}%");
    }

    public function scopePublished($query){
        return $query->where('published_at', '<=', now());
    }
}
