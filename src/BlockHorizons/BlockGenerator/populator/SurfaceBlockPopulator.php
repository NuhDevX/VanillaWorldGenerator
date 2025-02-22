<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\BlockFactory;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

abstract class SurfaceBlockPopulator extends PopulatorCount {
	
    protected function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void {
        $chunk = $world->getChunk($chunkX, $chunkZ);
        $x = $random->nextBoundedInt(16);
        $z = $random->nextBoundedInt(16);
        $y = $this->getHighestWorkableBlock($world, $x, $z, $chunk);
        if ($y > 0 && $this->canStay($x, $y, $z, $chunk)) {
            $this->placeBlock($x, $y, $z, $this->getBlockId($x, $z, $random, $chunk), $chunk, $random);
        }
    }

    protected abstract function canStay(int $x, int $y, int $z, Chunk $chunk) : bool;

    protected abstract function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int;

    protected function getHighestWorkableBlock(ChunkManager $world, int $x, int $z, Chunk $chunk) {
  		$y = 0;
        //start at 254 because we add one afterwards
        for ($y = 254; $y >= 0; --$y) {
            if (!PopulatorHelpers::isNonSolid($chunk->getBlockStateId($x, $y, $z))) {
                break;
            }
        }

        return $y === 0 ? -1 : ++$y;
    }

    protected function placeBlock(int $x, int $y, int $z, int $id, Chunk $chunk, Random $random) : void {
        $chunk->setBlockStateId($x, $y, $z, $id);
    }

}
