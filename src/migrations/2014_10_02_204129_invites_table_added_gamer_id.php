<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvitesTableAddedGamerId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invites', function($table)
		{
			$table -> bigInteger('gamer_invited_id') -> after('gamer_id') -> nullable() -> unsigned();

			$table -> index('gamer_invited_id');

			$table -> foreign('gamer_invited_id') -> references('id') -> on('gamers') -> onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invites', function($table)
		{
			$table -> dropColumn('gamer_invited_id');
		});
	}

}
