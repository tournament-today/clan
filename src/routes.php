<?php

Route::group(['namespace' => 'Syn'], function()
{
	Route::group([
		'before' 	=> ['auth'],
	], function()
	{
		/**
		 * MODEL BINDING
		 */
		Route::model('clan', 'Syn\Clan\Models\Clan');
		Route::model('clan_title', 'Syn\Clan\Models\ClanTitle');

		/**
		 * CLAN
		 */
		Route::get('/gamer/{gamer}/{name}/clans', [
			'as'	=> 'Gamer@clans',
			'uses'	=> 'Clan\Controllers\ClanController@gamerIndex'
		]);
		Route::any('/clan/create', [
			'as'	=> 'Clan@create',
			'uses'	=> 'Clan\Controllers\ClanController@edit'
		]);

		Route::any('/clans', [
			'as'	=> 'Clan@index',
			'uses'	=> 'Clan\Controllers\ClanController@index'
		]);
		Route::any('/clan/{clan}/{name}/edit', [
			'as'	=> 'Clan@edit',
			'uses'	=> 'Clan\Controllers\ClanController@edit'
		]);
		Route::any('/clan/{clan}/{name}/manage', [
			'as'	=> 'Clan@manage',
			'uses'	=> 'Clan\Controllers\ClanController@manage'
		]);
		Route::any('/clan/{clan}/{name}', [
			'as'	=> 'Clan@view',
			'uses'	=> 'Clan\Controllers\ClanController@show'
		]);
		Route::any('/clan/{clan}/{name}/title/{clan_title}/edit', [
			'as'	=> 'ClanTitle@edit',
			'uses'	=> 'Clan\Controllers\ClanTitleController@edit',
		]);
		Route::any('/clan/{clan}/{name}/title', [
			'as'	=> 'ClanTitle@create',
			'uses'	=> 'Clan\Controllers\ClanTitleController@edit',
		]);

		Route::get('/invite/{token}', [
			'as'	=> 'Clan@useInvite',
			'uses' 	=> 'Clan\Controllers\InviteController@useMailToken'
		]);
	});
});