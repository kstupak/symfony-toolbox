<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Utility;


final class InputStreamReader
{
    /** @var string */
    private $readingMode;

    public function __construct(string $readingMode = 'r')
    {
        $this->readingMode = $readingMode;
    }

    public function read(): string
    {
        $stream = fopen('php://input', $this->readingMode);
        $data = stream_get_contents($stream);
        fclose($stream);

        return $data;
    }
}