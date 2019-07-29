<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Product;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$items = CartItem::with('products')->get();
		return response()->json([
			'items' => $items,
			'products' => CartItem::getProducts($items),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$item = CartItem::where('product_id', '=', $request->id)->first();
		if (!is_null($item)) {
			return response()->json([
				'type' => 'info',
				'message' => 'item already exists in cart, please go to cart to add quantity of items needed.',
			]);
		} else {
			$item = CartItem::create(array(
				'product_id' => $request->id,
				'qty' => 1,
			));
			CartItem::addToCart($item->id);
			return response()->json([
				'type' => 'success',
				'message' => 'item has been added to cart',
				'item' => $item,
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\CartItem  $cartItem
	 * @return \Illuminate\Http\Response
	 */
	public function show(CartItem $cartItem)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\CartItem  $cartItem
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CartItem $cartItem)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\CartItem  $cartItem
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$item = CartItem::where('product_id', $request->products_id)
			->first();
		$item->update([
			'qty' => $request->quantity,
		]);
		return response()->json([
			'type' => 'success',
			'message' => 'quantity has been updated',
			'item' => $item,
			'subtotal' => $item->subtotal()
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\CartItem  $cartItem
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$item = CartItem::where('product_id', $id)->first();
		$item->delete();

		CartItem::deleteFromCart($item->id);
		return response()->json([
			'type' => 'success',
			'message' => 'has been removed from cart',
			'item' => $item
		]);
	}
}
