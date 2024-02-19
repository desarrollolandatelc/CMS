<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetUpMenuItemsModule extends Migration
{
	public function up()
	{
		Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->string('href');
            $table->boolean('status')->default(1);
            $table->text('internal_link');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('module_id')->nullable()->constrained('modules')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
	}
	
	public function down()
	{
		// Schema::dropIfExists('menu_items');
	}
}
