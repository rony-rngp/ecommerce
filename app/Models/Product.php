<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function product_colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function product_galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 1)->latest();
    }

    public function rating()
    {
        return $this->hasMany(ProductReview::class)
            ->select(DB::raw('ROUND(AVG(rating), 2) as average, COUNT(rating) as rating_count, product_id'))
            ->where('status', 1) // Only include reviews with status = 1
            ->groupBy('product_id');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getRatingPercentage()
    {
        // Get the total number of reviews
        $totalRatings = $this->reviews()->count();

        // Get the average rating
        $averageRating = $this->reviews()->avg('rating');

        // Assuming a rating scale from 1 to 5
        $maxRating = 5;

        // Calculate the percentage (if there are ratings)
        $percentage = $totalRatings > 0 ? ($averageRating / $maxRating) * 100 : 0;

        // Return the percentage rounded to two decimal places
        return round($percentage, 2);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function check_wish()
    {
        return $this->belongsTo(Wishlist::class, 'id', 'product_id')->where('user_id', Auth::id());
    }

}
