<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpModuleTypesModule extends Migration
{
	public function up()
	{
		Schema::create('module_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('module_name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
	}
	
	public function down()
	{
		// Schema::dropIfExists('module_types');
	}
}
