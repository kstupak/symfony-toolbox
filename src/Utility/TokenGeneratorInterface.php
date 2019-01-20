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


interface TokenGeneratorInterface
{
    const TOKEN_LENGTH = 16;
    const TOKEN_VOCAB = 'abcdefghijklmonpqrstuvwxyz1234567890';

    public function generate(int $tokenLength = self::TOKEN_LENGTH, string $vocabulary = self::TOKEN_VOCAB): string;
}