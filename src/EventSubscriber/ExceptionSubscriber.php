<?php
/*
 * This file is part of "symfony-toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Toolbox\Service\ExceptionResolver;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface  */
    private $logger;
    /** @var string  */
    private $env;
    /** @var ExceptionResolver */
    private $exceptionResolver;

    public function __construct(
        LoggerInterface $logger,
        ExceptionResolver $exceptionResolver,
        string $env = 'prod'
    ){
        $this->exceptionResolver = $exceptionResolver;
        $this->logger            = $logger;
        $this->env               = $env;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onException', PHP_INT_MAX]
        ];
    }

    public function onException(GetResponseForExceptionEvent $event)
    {
        $resolved = $this->exceptionResolver->resolve($event->getException());

        if ($this->env === 'dev') {
            $this->logger->critical(
                sprintf(
                    '%s @ %s:%s',
                    $event->getException()->getMessage(),
                    $event->getException()->getFile(),
                    $event->getException()->getLine())
            );
        }


        $event->setResponse(
            new JsonResponse(
                $this->env === 'dev'
                    ? $event->getException()->getMessage()
                    : $resolved->getMessage()
                , $resolved->getCode()
            )
        );
    }
}