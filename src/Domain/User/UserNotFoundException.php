<?php

declare(strict_types=1);

namespace App\Domain\User;

use \src\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
