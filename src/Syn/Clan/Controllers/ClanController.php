<?php namespace Syn\Clan\Controllers;

use DB;
use Input;
use Syn\Clan\Interfaces\ClanRepositoryInterface;
use Syn\Clan\Models\Clan;
use Syn\Clan\Models\ClanMember;
use Syn\Clan\Models\ClanTitle;
use Syn\Clan\Models\Invite;
use Syn\Framework\Abstracts\Controller;
use Syn\Gamer\Models\Gamer;

class ClanController extends Controller
{
	public $icon = "clan";

	public function __construct(ClanRepositoryInterface $clan)
	{
		$this -> clan = $clan;
	}

	public function edit(Clan $model = null, $name = null)
	{
		if(!$model)
			$model = $this -> clan -> getNewModel();

		if(!$model->allowEditOrCreate())
			return $this -> notAllowed('edit or create clan', 'missing access rights');


		$this -> title = $model -> exists ? trans('clan.clan-form-edit') : trans('clan.clan-form-create');

		return $this -> onRequestMethod('post', function() use ($model)
			{
				return $model -> validateAndSave();
			})
			?: $this -> view('pages.form', compact('model'));
	}

	public function index()
	{
		$models = $this -> clan -> paginate();
		$this -> title = trans_choice('clan.clan',2);
		return $this -> view('pages.clan.index', compact('models'));
	}
	/**
	 * @param Gamer $gamer
	 * @param null  $name
	 * @return mixed
	 */
	public function gamerIndex(Gamer $gamer, $name = null)
	{
		$clans = $gamer -> clans;

		$repo = $this -> clan;
		$this -> title = trans_choice('clan.clan',2);

		return $this -> onRequestMethod('post', function() use ($gamer, $repo)
			{
				$clan = $repo -> model -> newInstance();
				return $clan -> validateAndSave();
			})
			?: $this -> view('pages.clan.gamer-index', compact('clans', 'gamer','repo'));
	}

	/**
	 * @param Clan $clan
	 * @param null $name
	 * @return mixed
	 */
	public function show(Clan $clan, $name = null)
	{
		$this -> title = $name;

		return $this -> view('pages.clan.show', compact('clan'));
	}

	public function manage(Clan $clan, $name = null)
	{
		if(!$clan->membership)
			return $this -> notAllowed('edit clan', 'missing access rights');

		$return = $this -> onRequestMethod('post', function() use ($clan)
		{
			if(($clan->membership->manage_rights || $clan->membership->leader) && Input::get('update-titles'))
			{
				foreach(Input::get('title') as $member_id => $title_id)
				{
					$member = $clan -> members() -> find($member_id);
					// FIXME not available in form yet
					if($title_id == 0)
						$member -> delete();
					else
					{
						$member -> clan_title_id = $title_id;
						$member -> save();
					}
				}
				return $clan -> redirectManage;
			}
			if(($clan->membership->manage_invite || $clan->membership->leader) && Input::get('update-invite'))
			{
				foreach(Input::get('invite_title') as $invite_id => $clan_title_id)
				{
					$invite = $clan -> invites() -> find($invite_id);
					// skip where already used
					if(!$invite->usable)
						continue;
					$invite -> clan_title_id = $clan_title_id;
					$invite -> save();
				}
				return $clan -> redirectManage;
			}

			if(($clan->membership->manage_invite || $clan->membership->leader) && Input::get('add-invite'))
			{
				$invite = new Invite;
				$invite -> email_address = Input::get('email_address');
				$invite -> clan_title_id = Input::get('invite_title');
				$invite -> clan_id = $clan -> id;
				$invite -> save();
				return $clan -> redirectManage;
			}
		});

		$this -> title = trans('generic.edit');
		$this -> icon = 'edit';
		return $return ?: $this -> view('pages.clan.manage', compact('clan'));
	}
}