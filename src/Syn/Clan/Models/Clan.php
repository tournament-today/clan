<?php namespace Syn\Clan\Models;

use Auth, File;
use Redirect;
use Syn\Framework\Abstracts\Model;
use Syn\Framework\Exceptions\MissingMethodException;

class Clan extends Model
{
	public $_validation = [
		'name' => ['required', 'min:4', 'not_in:admin,noob,root,test,fail'],
		'tag' => ['required', 'between:2,5', 'alpha_num', 'unique:clans,tag', 'not_in:admin,noob,root,test,fail'],
		'url' => ['url'],
		'logo' => ['image', 'between:1,5000'],
	];

	public $_types = [
		'name' => 'text',
		'tag' => 'text',
		'url' => 'text',
		'logo' => 'file'
	];

	public $_upload_targets = [
		'logo' => 'logos'
	];
	/**
	 * Returns the parameter of an object to use in a SEO url
	 *
	 * @return mixed
	 */
	public function getLinkNameAttribute()
	{
		$name = $this -> name;

		return $name ? str_replace(['/', ' ','\''], ['-','-',''], $name) : '-';
	}

	public function getRedirectManageAttribute()
	{
		return $this -> redirectRouted("Clan@manage");
	}
	public function getLinkManageAttribute()
	{
		return $this -> linkRoute('Clan@manage');
	}
	/**
	 * RELATIONS
	 * ---------
	 */
	/**
	 * Members
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function members()
	{
		return $this -> hasMany('Syn\Clan\Models\ClanMember');
	}

	/**
	 * Possible clan titles
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function titles()
	{
		return $this -> hasMany(__NAMESPACE__.'\ClanTitle');
	}

	/**
	 * Invites outstanding
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invites()
	{
		return $this -> hasMany(__NAMESPACE__.'\Invite');
	}

	/**
	 * Loads membership of a clan for current user
	 * @return null
	 */
	public function getMembershipAttribute()
	{
		return Auth::check() ? Auth::user() -> membershipOf($this -> id) : null;
	}

	public function getShortUrlAttribute()
	{
		return preg_replace('/^(https?:\/\/)?(www\.)?/i',null,$this -> url);
	}
	public function getCompleteUrlAttribute()
	{
		// correct url
		if(!preg_match('/^https?:\/\//i', $this -> url))
			return sprintf("http://%s", $this -> url);

		return $this -> url;
	}

	public function getLogoUriAttribute()
	{
		return File::exists($this -> fileUploadPath('logo')) ? $this -> fileUploadUri('logo') : null;
	}

	public function allowEdit()
	{
		return $this->exists && $this->membership && ($this->membership->manage_clan || $this->membership->leader);
	}

	public function allowCreate()
	{
		return Auth::check();
	}
	public function cups()
	{
		return $this -> hasMany('Syn\Cup\Models\Cup');
	}

}