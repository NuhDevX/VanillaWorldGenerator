<?php

namespace BlockHorizons\BlockGenerator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use BlockHorizons\BlockGenerator\generators\UnoxGenerator;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\ItemTypeIds;
use pocketmine\world\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener
{

    public function onLoad()
    {
        CustomBiome::init();

        $b = new CustomBiomeSelector($r = new CustomRandom());
        $b->recalculate();

        @rmdir("worlds/real_level");
        @rmdir("worlds/unox_level");

        GeneratorManager::getInstance()->addGenerator(BlockGenerator::class, "normal", true);
        GeneratorManager::getInstance()->addGenerator(UnoxGenerator::class, "unox", false);

        $this->getServer()->getWorldManager()->generateWorld("real_level", 7331, BlockGenerator::class, []);
        $this->getServer()->getWorldManager()->loadWorld("real_level");

        $this->getServer()->getWorldManager()->generateWorld("unox_level", 7331, UnoxGenerator::class, []);
        $this->getServer()->getWorldManager()->loadWorld("unox_level");
    }

    public function onDisable() {
        @rmdir("worlds/real_level");
        @rmdir("worlds/unox_level");
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

	public function onPlayerMove(PlayerMoveEvent $event) {
		$player = $event->getPlayer();
        if($player->getInventory()->getItemInHand()->getTypeId() !== ItemTypeIds::STICK) return; //ini buat apa?

		$chunk = $player->getLevel()->getChunk($cx = $player->x >> 4, $cz = $player->z >> 4);
		$biome = CustomBiome::getBiome($chunk->getBiomeId($rx = $player->x % 16, $rz = $player->z % 16));
	}

	public static function pretty_constant(string $s) : string {
		$p = explode("_", $s);
		$r = "";
		foreach($p as $pp) {
			$r .= ucfirst(strtolower($pp))." ";
		}
		return trim($r);
	}

}
