<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpPersonTypesModule extends Migration
{
	public function up()
	{
		Schema::create('person_types', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('alias');
			$table->boolean('status')->default(false);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('person_types');
	}
}
