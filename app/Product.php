<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['name', 'price', 'detail', 'units'];

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'product_category');
	}

	public function cartItem()
	{
		return $this->belongsTo(CartItem::class, 'id');
	}
}
