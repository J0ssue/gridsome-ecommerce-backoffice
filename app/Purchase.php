<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	protected $fillable = ['product_id', 'qty', 'amount'];
	public function products()
	{
		return $this->hasMany(Product::class, 'id');
	}
}
