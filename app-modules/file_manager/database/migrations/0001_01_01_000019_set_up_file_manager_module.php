<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpFileManagerModule extends Migration
{
	public function up()
	{
		Schema::create('file_managers', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('path');
			$table->string('size');
			$table->string('extension');
			$table->string('mime_type');
			$table->string('type');
			$table->timestamps();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('file_manager');
	}
}
