<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\mushroom\BigMushroom;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\BlockTypeIds;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class MushroomPopulator extends PopulatorCount {
    
    private $type;

    public function __construct(int $type = null) {
        $this->type = $type === null ? mt_rand(0, 1) : $type;
    }

    public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random) : void {
        $x = ($chunkX << 4) | $random->nextBoundedInt(16);
        $z = ($chunkZ << 4) | $random->nextBoundedInt(16);
        $y = $this->getHighestWorkableBlock($world, $x, $z, $world->getChunk($chunkX, $chunkZ));
        if ($y !== -1) {
            (new BigMushroom($this->type))->generate($world, $random, new Vector3($x, $y, $z));
        }
    }

    protected function getHighestWorkableBlock(ChunkManager $world, int $x, int $z, Chunk $chunk) : int {
        $y = 0;
        $x &= 0xF;
        $z &= 0xF;
        for ($y = 254; $y > 0; --$y) {
            $b = $chunk->getBlockStateId($x, $y, $z);
            if ($b === BlockTypeIds::DIRT || $b === BlockTypeIds::GRASS || $b === BlockTypeIds::MYCELIUM) {
                break;
            } elseif ($b !== BlockTypeIds::AIR && $b !== BlockTypeIds::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}
