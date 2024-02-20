<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpSliderModule extends Migration
{
	public function up()
	{
		Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('module_id')->constrained('modules')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unique(['name', 'alias', 'module_id']);
            $table->timestamps();
        });
	}
	
	public function down()
	{
		// Schema::dropIfExists('slider');
	}
}
