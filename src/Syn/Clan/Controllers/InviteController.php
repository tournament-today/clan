<?php namespace Syn\Clan\Controllers;

use Syn\Clan\Models\Invite;
use Syn\Framework\Abstracts\Controller;

class InviteController extends Controller
{
	public function useMailToken($token)
	{
		$invite = Invite::where('token', $token) -> first();
		if($invite)
		{
			if($invite -> usable && $invite -> email_address == $this -> getVisitor() -> email_address)
			{
				$invite -> useFor();
				return $invite -> clan -> redirectView;
			}
			else
				return $this -> notAllowed('use-invite', 'token no longer usable or not available for your e-mail address');
		}
		else
			return $this -> notFound(trans('clan.token-not-found'));
	}
}