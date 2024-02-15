<?php

namespace Modules\Providers\Providers;

use Illuminate\Support\ServiceProvider;

class ProvidersServiceProvider extends ServiceProvider
{
	public function register()
	{
	}

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__ . '/../../routes/providers-routes.php');
	}
}
