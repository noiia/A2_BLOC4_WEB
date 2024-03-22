<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use \src\Domain\User\User;
use \src\Domain\User\UserNotFoundException;
use \src\Infrastructure\Persistence\User\InMemoryUserRepository;
use \tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new \src\Domain\User\User(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new \src\Infrastructure\Persistence\User\InMemoryUserRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new \src\Domain\User\User(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new \src\Domain\User\User(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new \src\Domain\User\User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new \src\Domain\User\User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new \src\Domain\User\User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];

        $userRepository = new \src\Infrastructure\Persistence\User\InMemoryUserRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new \src\Domain\User\User(1, 'bill.gates', 'Bill', 'Gates');

        $userRepository = new \src\Infrastructure\Persistence\User\InMemoryUserRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new \src\Infrastructure\Persistence\User\InMemoryUserRepository([]);
        $this->expectException(\src\Domain\User\UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }
}
