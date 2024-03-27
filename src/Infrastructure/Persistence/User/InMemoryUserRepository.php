<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use \src\Domain\User\User;
use \src\Domain\User\UserNotFoundException;
use \src\Domain\User\UserRepository;

class InMemoryUserRepository implements \src\Domain\User\UserRepository
{
    /**
     * @var \src\Domain\User\User[]
     */
    private array $users;

    /**
     * @param \src\Domain\User\User[]|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new \src\Domain\User\User(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new \src\Domain\User\User(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new \src\Domain\User\User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new \src\Domain\User\User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new \src\Domain\User\User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): \src\Domain\User\User
    {
        if (!isset($this->users[$id])) {
            throw new \src\Domain\User\UserNotFoundException();
        }

        return $this->users[$id];
    }
}
