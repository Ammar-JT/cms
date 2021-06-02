<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    //this fillable property allow you to make Mass Assignment
    protected $fillable = [
        'name'
    ];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
