<?php namespace Syn\Clan\Observers;

use App;
use Queue;
use Syn\Clan\Models\ClanMember;
use Syn\Clan\Models\ClanTitle;
use Syn\Framework\Exceptions\OverwriteProtectedPropertyException;
use Syn\Notification\Classes\HipChat;

class ClanObserver
{
	public function created($model)
	{
		$owner_title_id = ClanTitle::createDefaults($model -> id);

		$clanMember = new ClanMember;
		$clanMember -> gamer_id = App::make('Visitor') -> id;
		$clanMember -> clan_id = $model -> id;
		$clanMember -> clan_title_id = $owner_title_id;
		$clanMember -> save();

		Queue::push(function($job) use ($model, $clanMember)
		{
			HipChat::messageRoom("Signed up: {$clanMember->gamer->publishedName} ({$clanMember->gamer->email_address}) created clan {$model->name} with tag {$model->tag} and website ({$model->url}).");
			$job->delete();
		});
	}

	public function saving($model)
	{
		if($model -> isDirty("admin") && $model -> admin)
			throw new OverwriteProtectedPropertyException("Cannot make clan admin");
	}
}