<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PersonTypes\Models\PersonType;

class SetUpDocumentTypesModule extends Migration
{
	public function up()
	{
		Schema::create('document_types', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name')->unique();
			$table->string('alias');
			$table->boolean('status')->default(false);
			
			$table->foreignIdFor(PersonType::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();

			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		// Schema::dropIfExists('document_types');
	}
}
