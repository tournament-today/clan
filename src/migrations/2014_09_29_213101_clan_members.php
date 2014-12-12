<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClanMembers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clan_members', function($table)
		{
			$table -> bigIncrements('id');
			$table -> bigInteger('gamer_id') -> unsigned();
			$table -> bigInteger('clan_id') -> unsigned();
			$table -> bigInteger('clan_title_id') -> unsigned();
			$table -> timestamps();

			$table -> index('clan_title_id');
			$table -> index('gamer_id');
			$table -> index('clan_id');

			$table -> foreign('clan_id') -> references('id') -> on('clans');
			$table -> foreign('gamer_id') -> references('id') -> on('gamers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clan_members');
	}

}
