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


final class ArrayPropertyAccess
{
    private const DELIMITER = '.';

    /** @var array */
    private $source = [];

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    private function lookup(string $key, array $sample)
    {
        $tokens = explode(self::DELIMITER, $key);
        $token = array_shift($tokens);

        $data = array_key_exists($token, $sample)
            ? $sample[$token]
            : null;

        return (is_array($data) && !empty($tokens))
            ? $this->lookup(join(self::DELIMITER, $tokens), $data)
            : $data;
    }

    public function get(string $key, $default = null)
    {
        return $this->lookup($key, $this->source) ?? $default;
    }
}