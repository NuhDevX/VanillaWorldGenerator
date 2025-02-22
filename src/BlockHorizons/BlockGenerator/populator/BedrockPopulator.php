<?php

namespace BlockHorizons\BlockGenerator\populator;

use pocketmine\block\BlockTypeIds;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\populator\Populator;
use pocketmine\utils\Random;

class BedrockPopulator extends Populator
{

    /**
     * @param ChunkManager $level
     * @param int $chunkX
     * @param int $chunkZ
     * @param Random $random
     */
    public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $chunk = $world->getChunk($chunkX, $chunkZ);
        for ($x = 0; $x < 16; $x++) {
            for ($z = 0; $z < 16; $z++) {
                $chunk->setBlockStateId($x, 0, $z, BlockTypeIds::BEDROCK);
                for ($i = 1; $i < 5; $i++) {
                    if ($random->nextBoundedInt($i) == 0) { //decreasing amount
                        $chunk->setBlockStateId($x, $i, $z, BlockTypeIds::BEDROCK);
                    }
                }
            }
        }
    }

}
