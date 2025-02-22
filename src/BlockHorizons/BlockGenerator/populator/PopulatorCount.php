<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\helper\PopulatorHelpers;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

abstract class PopulatorCount extends Populator
{

    protected $randomAmount = 1;
    protected $baseAmount;
    protected $spreadChance = 0;

    public function setRandomAmount(int $randomAmount): void
    {
        $this->randomAmount = $randomAmount + 1;
    }

    public function setBaseAmount(int $baseAmount): void
    {
        $this->baseAmount = $baseAmount;
    }

    public function setSpreadChance(float $chance): void
    {
        $this->spreadChance = $chance;
    }

    public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
    {
        $count = $this->baseAmount + $random->nextBoundedInt($this->randomAmount);
        for ($i = 0; $i < $count; $i++) {
            $this->populateCount($level, $chunkX, $chunkZ, $random);
        }
    }

    protected abstract function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void;

    protected function spread(int $x, int $y, int $z, ChunkManager $world): ?Vector3
    {
        return null;
    }

}
