<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SetUpSiteModule extends Migration
{
	public function up()
	{
		// Schema::create('site', function(Blueprint $table) {
		// 	$table->bigIncrements('id');
		// 	$table->timestamps();
		// 	$table->softDeletes();
		// });
	}
	
	public function down()
	{
		// Schema::dropIfExists('site');
	}
}
