<?php namespace Syn\Clan\Repositories;

use Syn\Clan\Interfaces\ClanRepositoryInterface;
use Syn\Framework\Abstracts\Repository;

class ClanRepository extends Repository implements ClanRepositoryInterface
{

	/**
	 * Returns a query builder filtering on what is viewable
	 *
	 * @param $id
	 * @return mixed
	 */
	public function isViewable($id)
	{
		// TODO: Implement isViewable() method.
	}

	/**
	 * Returns a query builder filtering on what is editable
	 *
	 * @param $id
	 * @return mixed
	 */
	public function isEditable($id)
	{
		// TODO: Implement isEditable() method.
	}

	/**
	 * Returns a query builder filtering on what is deletable
	 *
	 * @param $id
	 * @return mixed
	 */
	public function isDeletable($id)
	{
		// TODO: Implement isDeletable() method.
	}

	/**
	 * Find clan by Tag
	 *
	 * @param $tag
	 * @return mixed
	 */
	public function findByTag($tag)
	{
		// TODO: Implement findByTag() method.
	}

	/**
	 * Find clans by gamer Id
	 *
	 * @param $gamer_id
	 * @return array
	 */
	public function findByGamer($gamer_id)
	{
		return $this -> model -> whereHas('members', function($q) use ($gamer_id)
		{
			$q -> where('gamer_id', $gamer_id);
		}) -> get();
	}
}