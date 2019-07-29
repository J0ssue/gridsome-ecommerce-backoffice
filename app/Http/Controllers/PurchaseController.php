<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Cart;
use App\CartItem;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;

class PurchaseController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
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
		// save order
		$order = collect($request->meta['order']);

		$stripe = new Stripe('sk_test_BqPzv8MeLTHA2uU4xejBcXgz00ZmkcMor0');
		try {

			//? make chaarge
			$charge = $stripe->charges()->create([
				'source' => $request->token_id,
				'currency' => 'EUR',
				'amount'   => $request->meta['amount'],
			]);

			$order->each(function ($item) {
				Purchase::create([
					'product_id' => $item['product_id'],
					'qty' => $item['qty'],
					'amount' => $item['amount']
				]);
			});

			// delete everything from cart
			$cart = Cart::all();
			$cart->each(function ($item) {
				$item->delete();
			});

			$items = CartItem::all();
			$items->each(function ($item) {
				$item->delete();
			});


			return response()->json([
				'type' => 'success',
				'message' => 'payment was successful, thank you for your purchase!',
				'charge' => $charge
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'type' => 'error',
				'message' => $th->message
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Purchase  $purchase
	 * @return \Illuminate\Http\Response
	 */
	public function show(Purchase $purchase)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Purchase  $purchase
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Purchase $purchase)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Purchase  $purchase
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Purchase $purchase)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Purchase  $purchase
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Purchase $purchase)
	{
		//
	}
}
