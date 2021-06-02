<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description','content','image','published_at', 'category_id'
    ];

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
}
