<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpCategoriesModule extends Migration
{
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('alias');
			$table->boolean('status')->default(1);
			$table->foreignId('parent_id')->nullable()->constrained('categories')->restrictOnDelete()->cascadeOnUpdate();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('categories');
	}
}
