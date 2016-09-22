<?php

namespace TomPedals\HelpScoutApp\Model;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testWithUserRole()
    {
        $user = new User(1, 'Tom', 'Graham', 'user', 0);

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isOwner());
    }

    public function testWithAdminRole()
    {
        $user = new User(1, 'Tom', 'Graham', 'admin', 0);

        $this->assertFalse($user->isUser());
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isOwner());
    }

    public function testWithOwnerRole()
    {
        $user = new User(1, 'Tom', 'Graham', 'owner', 0);

        $this->assertFalse($user->isUser());
        $this->assertFalse($user->isAdmin());
        $this->assertTrue($user->isOwner());
    }
}
