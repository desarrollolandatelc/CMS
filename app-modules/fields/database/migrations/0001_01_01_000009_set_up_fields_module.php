<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpFieldsModule extends Migration
{
	public function up()
	{
		Schema::create('fields', function (Blueprint $table) {
			$table->id();

			$table->string('name');
			$table->string('alias');
			$table->boolean('status')->default(1);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('fields');
	}
}
