<?php
/*
 * This file is part of "symfony-toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Service\API;


use Doctrine\Common\Collections\Collection;

interface SearchService
{
    public function search(string $query, ?Collection $filters = null): Collection;
}