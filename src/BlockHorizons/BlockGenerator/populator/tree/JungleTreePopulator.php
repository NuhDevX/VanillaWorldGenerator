<?php

namespace BLockHorizons\BlockGenerator\populator\tree;

use BlockHorizons\BlockGenerator\object\NewJungleTree;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\BlockTypeIds;
use pocketmine\world\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class JungleTreePopulator extends PopulatorCount
{

    protected $world;

    /** @var int */
    protected $type;

    public function __construct(int $type = \pocketmine\block\Wood::JUNGLE)
    {
        $this->type = $type;
    }

    public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->world= $world;
        $chunk = $world->getChunk($chunkX, $chunkZ);
        // This should be removed? As same things is done in PopulatorCount upon calling this method
        $amount = $random->nextBoundedInt($this->randomAmount + 1) + $this->baseAmount;
        $v = new Vector3();

        for ($i = 0; $i < $amount; ++$i) {
            $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
            $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if ($y === -1) {
                continue;
            }
            (new NewJungleTree(4 + $random->nextBoundedInt(7), 3))->generate($world, $random, $v->setComponents($x, $y, $z));
        }
    }

    protected function getHighestWorkableBlock(int $x, int $z): int
    {
        $y = 0;
        for ($y = 255; $y > 0; --$y) {
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
