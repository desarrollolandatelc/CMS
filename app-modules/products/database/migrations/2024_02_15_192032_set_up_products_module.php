<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SetUpProductsModule extends Migration
{
	public function up()
	{
		// Schema::create('products', function(Blueprint $table) {
		// 	$table->bigIncrements('id');
		// 	$table->timestamps();
		// 	$table->softDeletes();
		// });
	}
	
	public function down()
	{
		// Schema::dropIfExists('products');
	}
}
