<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Controller\Traits;

use Assert\Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

trait CanRespondWithJson
{
    /** @var SerializerInterface */
    private $serializer;

    private $defaultResponseHeaders = [
        'Content-Type' => 'application/json;charset=UTF-8'
    ];

    private function respond($data, int $code = Response::HTTP_OK, array $serializationGroups = [], array $customHeaders = []): Response
    {
        Assert::that($this->serializer)
            ->notEmpty('Serializer must be defined')
            ->isInstanceOf(SerializerInterface::class, 'Serializer must conform to SerializerInterface');

        $data = $this->serializer->serialize($data, 'json', ['groups' => $serializationGroups]);

        $headers = array_merge($customHeaders, $this->defaultResponseHeaders);

        return new Response($data, $code, $headers);
    }
}