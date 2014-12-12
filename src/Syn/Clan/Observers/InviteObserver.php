<?php namespace Syn\Clan\Observers;

use App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Queue;

class InviteObserver
{
	public function creating($model)
	{
		$model -> gamer_id = App::make("Visitor") -> id;
		$model -> invalidates_at = Carbon::now() -> addWeek();
		$model -> token = substr(md5($model -> email_address), 0, 15);
	}

	public function created($model)
	{
		Queue::push('Syn\Clan\Tasks\InviteTask@send', [
			'id' => $model -> id
		]);
	}
}