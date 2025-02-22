<?php

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\block\Block;
use pocketmine\world\generator\object\Tree;

abstract class CustomTree extends Tree
{

    public function canOverride(Block $block): bool
    {
        return isset($this->overridable[$block->getTypeId()]);
    }

}
