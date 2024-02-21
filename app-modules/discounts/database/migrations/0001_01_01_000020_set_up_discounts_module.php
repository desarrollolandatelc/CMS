<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpDiscountsModule extends Migration
{
	public function up()
	{
		Schema::create('discounts', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('alias');
			$table->string('product_field')->comment('Este es el nombre de la columna de la tabla de productos');
			$table->string('product_field_value')->comment('Este es el valor de la columna de la tabla de productos');
			$table->unsignedInteger('value')->comment('Este es el valor del descuento, representado en porcentaje');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->boolean('status')->default(1);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('discounts');
	}
}
