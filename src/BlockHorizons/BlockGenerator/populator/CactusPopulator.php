<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureBelow;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use pocketmine\block\BlockTypeIds;
use pocketmine\world\format\Chunk;
use pocketmine\utils\Random;

class CactusPopulator extends SurfaceBlockPopulator
{

    protected function canStay(int $x, int $y, int $z, Chunk $chunk): bool
    {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureBelow::ensureBelow($x, $y, $z, BlockTypeIds::SAND, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk): int
    {
        return BlockTypeIds::CACTUS;
    }

}
