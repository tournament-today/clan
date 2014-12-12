<?php namespace Syn\Clan\Models;

use Redirect;
use Syn\Framework\Abstracts\Model;
use Syn\Framework\Exceptions\MissingMethodException;

class ClanTitle extends Model
{
	public $_validation = [
		'clan_id' => ['required', 'exists:clans,id'],
		'title' => ['required'],
		'manage_clan' => ['boolean'],
		'manage_match_entry' => ['boolean'],
		'manage_own_match_subscription' => ['boolean'],
		'manage_match_subscriptions' => ['boolean'],
		'manage_rights' => ['boolean'],
		'manage_invite' => ['boolean'],
		'manage_kick' => ['boolean'],
		'manage_ban' => ['boolean'],
		'leader' => ['boolean'],
		'right_hand' => ['boolean'],
		'allow_adminning' => ['boolean'],
	];

	public $_types = [
		'title' => 'text',
		'manage_clan' => 'toggle',
		'manage_match_entry' => 'toggle',
		'manage_own_match_subscription' => 'toggle',
		'manage_match_subscriptions' => 'toggle',
		'manage_rights' => 'toggle',
		'manage_invite' => 'toggle',
		'manage_kick' => 'toggle',
		'manage_ban' => 'toggle',
		'leader' => 'toggle',
		'right_hand' => 'toggle',
		'allow_adminning' => 'toggle',
	];


	public function getRedirectEditAttribute()
	{
		return Redirect::route("ClanTitle@edit", ['clan_id' => $this -> clan_id, 'name' => $this -> clan -> linkName, 'title_id' => $this -> id]);
	}
	public function getRedirectViewAttribute()
	{
		return $this -> clan -> redirectManage;
	}
	public function getLinkEditAttribute()
	{
		return route('ClanTitle@edit', ['clan_id' => $this -> clan_id, 'name' => $this -> clan -> linkName, 'title_id' => $this -> id]);
	}

	/**
	 * @return mixed
	 */
	public function getLinkNameAttribute()
	{
		return $this -> title;
	}

	/**
	 * Creates an owner
	 * @param $clan_id
	 * @return mixed
	 */
	public static function createDefaults($clan_id)
	{
		$owner = new Self;
		$owner -> clan_id = $clan_id;
		$owner -> title = trans('clan.title-owner');
		$owner -> leader = true;
		$owner -> save();

		return $owner -> id;
	}

	/**
	 * Clan relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function clan()
	{
		return $this -> belongsTo(__NAMESPACE__.'\Clan');
	}

	public function allowEdit()
	{
		parent::allowEdit(); // TODO: Change the autogenerated stub
	}

	public function allowEditOrCreate()
	{

		if($this->clan->membership && ($this->clan->membership->manage_rights || $this->clan->membership->leader))
			return true;

		return false;
	}


}