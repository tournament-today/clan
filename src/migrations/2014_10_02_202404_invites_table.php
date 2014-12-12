<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invites', function($table)
		{
			$table -> bigIncrements('id');
			$table -> string('token');
			$table -> string('custom_message') -> nullable();
			$table -> bigInteger('clan_id') -> unsigned();
			$table -> bigInteger('clan_title_id') -> unsigned();
			$table -> bigInteger('gamer_id') -> unsigned();
			$table -> timestamp('invalidates_at');
			$table -> timestamps();

			$table -> index('clan_id');
			$table -> index('clan_title_id');
			$table -> index('gamer_id');

			$table -> foreign('clan_id') -> references('id') -> on('clans') -> onDelete('cascade');
			$table -> foreign('clan_title_id') -> references('id') -> on('clan_titles') -> onDelete('cascade');
			$table -> foreign('gamer_id') -> references('id') -> on('gamers') -> onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invites');
	}

}
