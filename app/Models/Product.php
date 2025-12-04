<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'size_id',
        'product_model_id',
        'color_id',
        'brand_id',
        'name',
        'sku',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function productModel(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
