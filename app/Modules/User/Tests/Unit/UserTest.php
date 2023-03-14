<?php

namespace App\Modules\User\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Modules\User\Domain\Entities\User;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_name_attribute(): void
    {
        $user = new User(['first_name' => 'Manson', 'last_name' => 'Xasthur']);

        $this->assertSame('Manson Xasthur', $user->name);
    }
}
