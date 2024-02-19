<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleTypes\Models\ModuleType;

class SetUpModulesModule extends Migration
{
	public function up()
	{
		Schema::create('modules', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('alias');
			$table->foreignIdFor(ModuleType::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->boolean('status')->default(1);
			$table->string('position')->nullable();
			$table->string('view_path')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('modules');
	}
}
