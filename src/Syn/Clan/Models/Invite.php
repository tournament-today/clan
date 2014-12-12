<?php namespace Syn\Clan\Models;

use App;
use Carbon\Carbon;
use Syn\Framework\Abstracts\Model;

class Invite extends Model
{
	/**
	 * The clan for which the invite is send
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function clan()
	{
		return $this -> belongsTo(__NAMESPACE__.'\Clan');
	}

	/**
	 * The gamer who send the invite
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function gamer()
	{
		return $this -> belongsTo('Syn\Gamer\Models\Gamer');
	}

	/**
	 * The title the invite will provide
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function title()
	{
		return $this -> belongsTo(__NAMESPACE__.'\ClanTitle', 'clan_title_id');
	}

	/**
	 * The invited gamer
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function gamerInvited()
	{
		return $this -> belongsTo('Syn\Gamer\Models\Gamer', 'gamer_invited_id');
	}

	/**
	 * Whether the invite is still usable
	 * @return bool
	 */
	public function getUsableAttribute()
	{
		return empty($this -> gamer_invited_id) && !$this -> expired;
	}

	/**
	 * whether the invite is expired
	 * @return bool
	 */
	public function getExpiredAttribute()
	{
		$invalidates_at = new Carbon($this -> invalidates_at);
		$now = new Carbon;
		return $invalidates_at -> lt($now);
	}

	/**
	 * Adds right to current logged in user
	 */
	public function useFor()
	{
		$right = new ClanMember;
		$right -> unguard();
		$right -> fill(array_only($this->getAttributes(), ['clan_id', 'clan_title_id']));
		$right -> gamer_id = App::make('Visitor') -> id;
		$right -> reguard();
		$right -> save();

		$this -> gamer_invited_id = App::make('Visitor') -> id;
		$this -> save();
	}
}