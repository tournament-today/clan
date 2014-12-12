<?php namespace Syn\Clan\Models;

use Syn\Framework\Abstracts\Model;

class ClanMember extends Model
{

	/**
	 * RELATIONS
	 * ---------
	 */

	/**
	 * Clan relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function clan()
	{
		return $this -> belongsTo(__NAMESPACE__.'\Clan');
	}

	/**
	 * Gamer relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function gamer()
	{
		return $this -> belongsTo('Syn\Gamer\Models\Gamer');
	}

	/**
	 * Title relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function title()
	{
		return $this -> belongsTo(__NAMESPACE__.'\ClanTitle', 'clan_title_id');
	}
}