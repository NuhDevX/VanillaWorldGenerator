<?php

namespace BlockHorizons\BlockGenerator\populator\tree;

use BlockHorizons\BlockGenerator\object\NewJungleTree;
use pocketmine\world\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class JungleFloorPopulator extends JungleTreePopulator
{

    public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->world = $world;
        $chunk = $world->getChunk($chunkX, $chunkZ);
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

}
