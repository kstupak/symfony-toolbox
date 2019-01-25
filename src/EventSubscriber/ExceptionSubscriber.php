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
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var string  */
    private $env;

    public function __construct(
        LoggerInterface $logger,
        string $env = 'prod'
    ){
        $this->logger           = $logger;
        $this->env              = $env;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onException', PHP_INT_MAX]
        ];
    }

    public function onException(GetResponseForExceptionEvent $event)
    {
        $exceptionClass = get_class($event->getException());

        switch ($exceptionClass) {
            case \InvalidArgumentException::class:
                $code = Response::HTTP_BAD_REQUEST;
                $message = 'Bad request';
                break;
            case \Assert\InvalidArgumentException::class:
                $code = Response::HTTP_BAD_REQUEST;
                $message = $event->getException()->getMessage();
                break;

            case NotFoundHttpException::class:
                $code = Response::HTTP_NOT_FOUND;
                $message = 'Resource not found';
                break;

            case BadRequestHttpException::class:
                $code = Response::HTTP_BAD_REQUEST;
                $message = 'Bad request';
                break;

            case AccessDeniedException::class:
                $code = Response::HTTP_FORBIDDEN;
                $message = 'Forbidden';
                break;

            default:
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = 'Error';
                break;
        }

        $this->logger->critical(sprintf('%s @ %s:%s', $event->getException()->getMessage(), $event->getException()->getFile(), $event->getException()->getLine()));
        $event->setResponse(new JsonResponse($this->env === 'dev' ? $event->getException()->getMessage() : $message, $code));
    }
}