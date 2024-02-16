<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Providers\Models\Provider;
use Modules\Titles\Models\Title;

class SetUpProductsModule extends Migration
{
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('sku');
			$table->string('barcode');
			$table->text('description');
			$table->text('images');
			$table->integer('min_quantity');
			$table->integer('max_quantity');
			$table->decimal('price', 10, 2);
			$table->text('fields')->nullable();
			$table->enum('condition', ['new', 'used'])->default('new');
			$table->boolean('status')->default(1);
			$table->foreignId('category_id')->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Title::class)->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->foreignId('currency_id')->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Provider::class)->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('products');
	}
}
