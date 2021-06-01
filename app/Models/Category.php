<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //this fillable property allow you to make Mass Assignment
    protected $fillable = [
        'name'
    ];

}
