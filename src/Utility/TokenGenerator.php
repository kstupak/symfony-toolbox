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

use RandomLib\Factory;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(int $length = self::TOKEN_LENGTH, string $vocab = self::TOKEN_VOCAB): string
    {
        $generator = (new Factory())->getMediumStrengthGenerator();

        return $generator->generateString($length, $vocab);
    }
}