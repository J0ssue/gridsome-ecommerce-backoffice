<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;
use App\Product;

class CartItem extends Model
{
	protected $fillable = [
		'cart_id', 'product_id', 'qty'
	];

	static public function addToCart($id)
	{
		$cart = Cart::create([
			'cart_item_id' => $id
		]);
		return $cart->id;
	}

	public function getProductQty($id)
	{
		$qty = CartItem::find($id);
		return $qty;
	}

	static public function getProducts($items)
	{
		$products = Product::all();
		$filtered = [];
		for ($i = 0; $i < count($products); $i++) {
			for ($j = 0; $j < count($items); $j++) {
				if ($products[$i]->id === $items[$j]->product_id) {
					array_push($filtered, $products[$i]);
				}
			}
		}
		return $filtered;
	}

	public function subtotal()
	{
		$product = Product::find($this->product_id);
		return $this->qty * $product->price;
	}

	static public function deleteFromCart($id)
	{
		$item = Cart::where('cart_item_id', $id)->first();
		$item->delete();
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'id');
	}
}
