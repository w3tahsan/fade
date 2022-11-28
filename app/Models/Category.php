<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['category_name', 'category_image'];


    function rel_to_user(){
        return $this->belongsTo(User::class, 'added_by');
    }

    function rel_to_subcategory(){
        return $this->hasMany(Subcategory::class, 'id');
    }
}
