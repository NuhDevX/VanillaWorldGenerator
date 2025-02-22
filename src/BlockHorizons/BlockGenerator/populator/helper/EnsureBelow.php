<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\world\format\Chunk;

class EnsureBelow
{

    private function __construct()
    {
    }

    public static function ensureBelow(int $x, int $y, int $z, int $id, Chunk $chunk): bool
    {
        return $chunk->getBlockStateId($x, $y - 1, $z) === $id;
    }

}
