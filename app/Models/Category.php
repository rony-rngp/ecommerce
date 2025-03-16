<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function active_subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id')->where('status', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function active_products()
    {
        return $this->hasMany(Product::class)->where('status', 1);
    }
}
