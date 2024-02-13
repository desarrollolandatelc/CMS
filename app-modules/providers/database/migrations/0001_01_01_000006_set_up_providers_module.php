<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\DocumentTypes\Models\DocumentType;
use Modules\PersonTypes\Models\PersonType;

class SetUpProvidersModule extends Migration
{
	public function up()
	{
		Schema::create('providers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('alias');
			$table->string('document_number');
			$table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->boolean('status')->default(false);
			$table->foreignIdFor(DocumentType::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(PersonType::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();

			$table->unique(['name', 'document_number']);

			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	public function down()
	{
		// Schema::dropIfExists('providers');
	}
}
