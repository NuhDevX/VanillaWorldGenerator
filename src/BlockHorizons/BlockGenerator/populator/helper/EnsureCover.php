<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\world\format\Chunk;

class EnsureCover
{

    private function __construct()
    {
    }

    public static function ensureCover(int $x, int $y, int $z, Chunk $chunk): bool
    {
        $id = $chunk->getBlockStateId($x, $y, $z);
        return $id->canBeReplaced();
    }

}
