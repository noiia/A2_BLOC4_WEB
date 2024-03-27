<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use \src\Application\Actions\ActionError;
use \src\Application\Actions\ActionPayload;
use \src\Application\Handlers\HttpErrorHandler;
use \src\Domain\User\User;
use \src\Domain\User\UserNotFoundException;
use \src\Domain\User\UserRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use \tests\TestCase;

class ViewUserActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new \src\Domain\User\User(1, 'bill.gates', 'Bill', 'Gates');

        $userRepositoryProphecy = $this->prophesize(\src\Domain\User\UserRepository::class);
        $userRepositoryProphecy
            ->findUserOfId(1)
            ->willReturn($user)
            ->shouldBeCalledOnce();

        $container->set(\src\Domain\User\UserRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/users/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $user);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsUserNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $userRepositoryProphecy = $this->prophesize(\src\Domain\User\UserRepository::class);
        $userRepositoryProphecy
            ->findUserOfId(1)
            ->willThrow(new \src\Domain\User\UserNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(\src\Domain\User\UserRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/users/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The user you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
