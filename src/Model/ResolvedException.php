<?php
/*
 * This file is part of "symfony-toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Model;


final class ResolvedException
{
    const DEFAULT_CODE    = 500;
    const DEFAULT_MESSAGE = 'Error';

    /** @var string */
    private $message;
    /** @var int */
    private $code;

    public function __construct(
        string $message = self::DEFAULT_MESSAGE,
        int $code       = self::DEFAULT_CODE
    ){
        $this->message = $message;
        $this->code    = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}