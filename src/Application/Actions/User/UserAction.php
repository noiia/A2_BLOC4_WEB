<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use \src\Application\Actions\Action;
use \src\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected \src\Domain\User\UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, \src\Domain\User\UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}
