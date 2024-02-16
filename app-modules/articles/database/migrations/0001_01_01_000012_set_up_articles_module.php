<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpArticlesModule extends Migration
{
	public function up()
	{
		Schema::create('articles', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('alias');
			$table->string('description');
			$table->boolean('status')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('articles');
	}
}
