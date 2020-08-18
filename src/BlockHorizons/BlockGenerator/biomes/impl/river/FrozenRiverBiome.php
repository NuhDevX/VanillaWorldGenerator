<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\river;

use BlockHorizons\BlockGenerator\biomes\type\WateryBiome;
use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;

class FrozenRiverBiome extends RiverBiome {
	
	public function __construct() {
        parent::__construct();

        $ice = new WaterIcePopulator();
        $this->addPopulator($ice);
    }

    public function getName() : string {
        return "Frozen River";
    }

    public function isFreezing() : bool {
        return true;
    }

}