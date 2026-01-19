<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['cat_name', 'description', 'price', 'category_id', 'img', 'is_active', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function category() {
        return $this->hasMany(Category::class);
    }
}
