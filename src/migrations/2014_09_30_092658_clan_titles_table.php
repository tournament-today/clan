<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClanTitlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('clan_titles', function($table)
		{
			$table -> bigIncrements('id');
			$table -> string('title') -> nullable();

			$table -> boolean('manage_match_entry');
			$table -> boolean('manage_own_match_subscription');
			$table -> boolean('manage_match_subscriptions');
			$table -> boolean('manage_clan');
			$table -> boolean('manage_rights');
			$table -> boolean('manage_invite');
			$table -> boolean('manage_kick');
			$table -> boolean('manage_ban');

			$table -> boolean('leader');
			$table -> boolean('right_hand');

			$table -> timestamps();
		});

		Schema::table('clan_members', function($table)
		{
			$table -> foreign('clan_title_id') -> references('id') -> on('clan_titles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
