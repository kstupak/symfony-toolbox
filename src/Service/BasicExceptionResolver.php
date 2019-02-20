<?php
/*
 * This file is part of "symfony-toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Service;

use Symfony\Component\HttpFoundation\Response;
use Toolbox\Model\ResolvedException;

class BasicExceptionResolver implements ExceptionResolver
{
    public function resolve(\Throwable $e): ResolvedException
    {
        $exceptionClass = get_class($e);

        switch ($exceptionClass) {
            case \InvalidArgumentException::class:
                $resolved = new ResolvedException('Bad request', Response::HTTP_BAD_REQUEST);
                break;
            case \Assert\InvalidArgumentException::class:
                $resolved = new ResolvedException($e->getMessage(), Response::HTTP_BAD_REQUEST);
                break;

            case NotFoundHttpException::class:
                $resolved = new ResolvedException('Resource not found', Response::HTTP_NOT_FOUND);
                break;

            case BadRequestHttpException::class:
                $resolved = new ResolvedException('Bad request', Response::HTTP_BAD_REQUEST);
                break;

            case AccessDeniedException::class:
                $resolved = new ResolvedException('Forbidden', Response::HTTP_FORBIDDEN);
                break;

            default:
                $resolved = new ResolvedException('Error', Response::HTTP_INTERNAL_SERVER_ERROR);
                break;
        }

        return $resolved;
    }
}