<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\SurfaceBlockPopulator;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockFactory;
use pocketmine\world\format\Chunk;
use pocketmine\utils\Random;

class DoublePlantPopulator extends SurfaceBlockPopulator {
	
	private $type;

    public function __construct(int $type)    {
        $this->type = $type;
    }

    protected function canStay(int $x, int $y, int $z, Chunk $chunk) : bool {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureCover::ensureCover($x, $y + 1, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int {
        return BlockTypeIds::DOUBLE_PLANT; //hah emang ada Double Plant di Minecraft?
    }

    protected function placeBlock(int $x, int $y, int $z, int $id, Chunk $chunk, Random $random) : void {
        $chunk->setBlockStateId($x, $y, $z, $id, $this->type);
        $chunk->setBlockStateId($x, $y + 1, $z, $id, $this->type);
    }

}
