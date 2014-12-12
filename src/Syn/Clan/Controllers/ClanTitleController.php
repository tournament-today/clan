<?php namespace Syn\Clan\Controllers;

use Input;
use Syn\Clan\Models\Clan;
use Syn\Clan\Models\ClanTitle;
use Syn\Framework\Abstracts\Controller;

class ClanTitleController extends Controller
{
	public function edit(Clan $clan, $name, ClanTitle $model = null)
	{
		$this -> icon = 'edit';
		$this -> title = trans('clan.clan-edit-title');

		if(!$model->exists)
			$model->clan_id = $clan->id;

		if(!$model->allowEditOrCreate())
			return $this -> notAllowed('edit title', 'missing manage_rights');

		$this -> title = $model -> exists ? trans('clan.clan-form-edit') : trans('clan.clan-form-create');

		return $this -> onRequestMethod('post', function() use ($model)
		{
			return $model -> validateAndSave();
		})
			?: $this -> view('pages.form', compact('model'));
	}

	public function create(Clan $clan, $name = null)
	{
		$clanTitle = new ClanTitle();
		$clanTitle -> clan_id = $clan -> id;

		if(!$clanTitle->clan->membership || !($clanTitle->clan->membership->manage_rights || $clanTitle->clan->membership->leader))
			return $this -> notAllowed('create title', 'missing manage_rights');

		$return = $this -> onRequestMethod('post', function() use ($clanTitle)
		{
			// get the validator
			$validator = $clanTitle -> getValidator(Input::except(['_token','edit-title']));
			// validate and redirect on fail
			if($validator -> fails())
				return $clanTitle->redirectEdit()->withInput()->withErrors($validator);

			$clanTitle -> unguard();
			$clanTitle -> fill(Input::except(['_token','edit-title']));
			$clanTitle -> save();
			return $clanTitle->clan->redirectEdit;
		});

		$this -> icon = 'create';
		$this -> title = trans('clan.clan-create-title');
		return $return ?: $this -> view('pages.clan.title.edit', compact('clanTitle'));
	}
}