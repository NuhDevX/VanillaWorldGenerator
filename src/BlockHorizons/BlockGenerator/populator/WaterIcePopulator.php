<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\block\BlockTypeIds;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\populator\Populator;
use pocketmine\utils\Random;

class WaterIcePopulator extends Populator {

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void {
          $chunk = $world->getChunk($chunkX, $chunkZ);
        for ($x = 0; $x < 16; $x++) {
            for ($z = 0; $z < 16; $z++) {
                $biome = CustomBiome::getBiome($chunk->getBiomeId($x, $z));
                if ($biome->isFreezing()) {
                    $topBlock = $chunk->getHighestBlockAt($x, $z);
                    if ($chunk->getBlockStateId($x, $topBlock, $z) == BlockTypeIds::WATER)     {
                        $chunk->setBlockStateId($x, $topBlock, $z, BlockTypeIds::ICE);
                    }
                }
            }
        }
    }

}
