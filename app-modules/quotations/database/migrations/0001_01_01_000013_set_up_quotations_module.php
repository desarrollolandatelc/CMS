<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Clients\Models\Client;

class SetUpQuotationsModule extends Migration
{
	public function up()
	{
		Schema::create('quotations', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->foreignIdFor(Client::class)->constrained()->restrictOnDelete()->cascadeOnUpdate();
			$table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
			$table->text('details');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('quotations');
	}
}
