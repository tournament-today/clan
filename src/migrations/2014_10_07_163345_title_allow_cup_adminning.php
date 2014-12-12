<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TitleAllowCupAdminning extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clan_titles', function($table)
		{
			$table -> boolean('allow_adminning')->default(false)->after('right_hand');
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
			$table -> dropColumn('allow_adminning');
		});
	}

}
