<?php

namespace BlockHorizons\BlockGenerator\populator\tree;

use BlockHorizons\BlockGenerator\object\SwampTree;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\BlockTypeIds;
use pocketmine\world\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class SwampTreePopulator extends PopulatorCount
{

    private $level;

    private $type;

    public function __construct(int $type = \pocketmine\block\utils\WoodType::OAK)
    {
        $this->type = $type;
    }

    public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->world = $world;

        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y === -1) {
            return;
        }
        (new SwampTree($this->type))->generate($world, $random, new Vector3($x, $y, $z));
    }

    private function getHighestWorkableBlock(int $x, int $z): int
    {
        $y;
        for ($y = 127; $y > 0; --$y) {
            $b = $this->world->getBlockAt($x, $y, $z);
            if ($b === BlockTypeIds::DIRT || $b === BlockTypeIds::GRASS || $b === BlockTypeIds::TALL_GRASS) {
                break;
            } elseif ($b !== BlockTypeIds::AIR && $b !== BlockTypeIds::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}
