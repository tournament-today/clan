<?php namespace Syn\Clan;

use Illuminate\Support\ServiceProvider;
use Syn\Clan\Models\Clan;
use Syn\Clan\Models\Invite;
use Syn\Clan\Observers\ClanObserver;
use Syn\Clan\Observers\InviteObserver;
use Syn\Clan\Repositories\ClanRepository;

class ClanServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this -> package('syn/clan');

		Invite::observe(new InviteObserver);
		Clan::observe(new ClanObserver);

		include __DIR__ . '/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this -> app -> bind('Syn\Clan\Interfaces\ClanRepositoryInterface', function()
		{
			return new ClanRepository(new Clan);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
