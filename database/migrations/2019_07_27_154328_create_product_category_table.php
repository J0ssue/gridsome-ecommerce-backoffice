<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_category', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('product_id');
			$table->unsignedInteger('category_id');

			// $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			// $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_category');
	}
}
