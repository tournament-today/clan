<?php namespace Syn\Clan\Tasks;

use Mail;
use Syn\Clan\Models\Invite;

class InviteTask
{
	public function send($job, $data)
	{
		$invite_id = array_get($data, 'id');
		if(!$invite_id)
			return $job -> delete();

		$invite = Invite::find($invite_id);
		if(!$invite)
			return $job -> delete();

		if(!$invite -> usable)
			return $job -> delete();

		Mail::send('e-mail.invited_for_clan',compact('invite'), function($message) use ($invite)
		{
			$message -> to($invite -> email_address, '') -> subject("Invited by {$invite->gamer->publishedName}");
		});

		$job -> delete();
	}
}