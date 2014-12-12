<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClanTitlesAddClanId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clan_titles', function($table)
		{
			$table -> bigInteger('clan_id') -> unsigned();
			$table -> index('clan_id');
			$table -> foreign('clan_id') -> references('id') -> on('clans');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clan_titles', function($table)
		{
			$table -> dropColumn('clan_id');
		});
	}

}
