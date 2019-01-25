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


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Toolbox\Utility\InputStreamReader;

final class RequestSubscriber
{
    /** @var InputStreamReader  */
    private $inputStreamReader;

    private $whitelistedContentTypes = [
        'application/json',
        'application/json;charset=utf-8'
    ];

    public function __construct(InputStreamReader $inputStreamReader)
    {
        $this->inputStreamReader = $inputStreamReader;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => [
                ['updateRequestContent', PHP_INT_MAX],
            ],
        ];
    }

    public function updateRequestContent(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (in_array($request->getMethod(), [Request::METHOD_GET, Request::METHOD_DELETE])) {
            return;
        }

        if (!in_array(strtolower($request->headers->get('Content-Type')), $this->whitelistedContentTypes)) {
            return;
        }

        $content = $this->inputStreamReader->read();

        if (!$content) {
            $content = $request->request->all();
            $content = array_shift($content);
        }

        $content = \json_decode($content, true);

        if (!$content || !is_array($content)) {
            throw new BadRequestHttpException();
        }

        $request->request->replace($content);
    }
}