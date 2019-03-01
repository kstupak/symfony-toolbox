<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Model\Filter;

use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public static function getName(): string;
    public static function createForValue($value): self;

    public function applyTo(QueryBuilder $builder, string $rootAlias = null);
}