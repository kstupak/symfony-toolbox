<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Service\API;

use Doctrine\Common\Collections\Collection;

interface CRUDService
{
    public function list(?Collection $filters = null): Collection;
    public function get(string $id);
    public function create($data);
    public function update(string $id, $data);
    public function delete(string $id): bool;
}