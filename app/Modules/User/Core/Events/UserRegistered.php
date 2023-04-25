<?php

namespace App\Modules\User\Core\Events;

use Illuminate\Queue\SerializesModels;
use App\Modules\User\Domain\Entities\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user)
    {
        //
    }
}
