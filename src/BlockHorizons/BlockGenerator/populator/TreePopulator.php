<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\AcaciaTree;
use BlockHorizons\BlockGenerator\object\BigSpruceTree;
use pocketmine\block\Block;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\object\BirchTree;
use pocketmine\world\generator\object\JungleTree;
use pocketmine\world\generator\object\OakTree;
use pocketmine\world\generator\object\SpruceTree;
use pocketmine\utils\Random;

class TreePopulator extends PopulatorCount
{

    private $type;
    private $super;
    private $world;

    public function __construct(int $type = \pocketmine\block\utils\WoodType::OAK, bool $super = false)
    {
        $this->type = $type;
        $this->super = $super;
    }

    public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->world = $world;
        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y < 3) {
            return;
        }

        switch ($this->type) {
            case \pocketmine\block\utils\WoodType::SPRUCE:
                if ($this->super) {
                    $tree = new BigSpruceTree(2, 8); // TODO: does normal API ?
                } else {
                    $tree = new SpruceTree();
                }
                break;
            case \pocketmine\block\utils\WoodType::BIRCH:
                $tree = new BirchTree($this->super);
                break;
            case \pocketmine\block\utils\WoodType::JUNGLE:
                $tree = new JungleTree();
                break;
            case \pocketmine\block\utils\WoodType::ACACIA:
                $tree = new AcaciaTree();
                break;
            case \pocketmine\block\utils\WoodType::DARK_OAK:
                return; //TODO
            default:
                $tree = new OakTree();
                /*if($random->nextRange(0, 9) === 0){
                    $tree = new BigTree();
                }else{*/

                //}
                break;
        }
        if ($tree->canPlaceObject($level, $x, $y, $z, $random)) {
            $tree->placeTrunk($level, $x, $y, $z, $random); //placeobject mungkin di ganti PlaceTrunk
        }
    }

    private function getHighestWorkableBlock(int $x, int $z): int
    {
        for ($y = 254; $y > 0; --$y) {
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
