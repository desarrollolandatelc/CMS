<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpSiteModule extends Migration
{
	public function up()
	{
		Schema::create('sites', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('alias');
			$table->boolean('status')->default(1);
			$table->string('config');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('site');
	}
}
