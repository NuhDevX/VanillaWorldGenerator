<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\BlockTypeIds;
use pocketmine\world\format\Chunk;

class PopulatorHelpers
{

    const NON_SOLID = [
        BlockTypeIds::AIR => true,
        BlockTypeIds::OAK_LEAVES => true,
        BlockTypeIds::JUNGLE_LEAVES => true,
        BlockTypeIds::DARK_OAK_LEAVES => true,
        BlockTypeIds::SPRUCE_LEAVES => true,
        BlockTypeIds::BIRCH_LEAVES => true,
        BlockTypeIds::MANGROVE_LEAVES => true,
        BlockTypeIds::AZALEA_LEAVES => true,
        BlockTypeIds::CHERRY_LEAVES => true,
        BlockTypeIds::ACACIA_LEAVES => true,
        BlockTypeIds::BIRCH_LEAVES => true,
        BlockTypeIds::SNOW_LAYER => true,
        BlockTypeIds::TALL_GRASS => true,
    ];

    private function __construct()
    {
    }

    public static function canGrassStay(int $x, int $y, int $z, Chunk $chunk): bool
    {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
    }

    public static function isNonSolid(int $id): bool
    {
        return isset(self::NON_SOLID[$id]);
    }

}
