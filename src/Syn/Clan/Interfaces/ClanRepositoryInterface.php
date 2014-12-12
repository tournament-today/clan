<?php namespace Syn\Clan\Interfaces;

use Syn\Framework\Abstracts\RepositoryInterface;

interface ClanRepositoryInterface extends RepositoryInterface
{
	/**
	 * Find clan by Id
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * Find clan by Tag
	 * @param $tag
	 * @return mixed
	 */
	public function findByTag($tag);

	/**
	 * Find clans by gamer Id
	 * @param $gamer_id
	 * @return array
	 */
	public function findByGamer($gamer_id);
}