<?php

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\world\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class SwampTree extends CustomTree
{

    public function __construct()
    {
    }

    public function generate(ChunkManager $worldIn, Random $rand, Vector3 $vectorPosition): bool
    {
        $position = $vectorPosition->floor();

        $i = $rand->nextBoundedInt(4) + 5;
        $flag = true;

        if ($position->getY() >= 1 && $position->getY() + $i + 1 <= 256) {
            for ($j = $position->getY(); $j <= $position->getY() + 1 + $i; ++$j) {
                $k = 1;

                if ($j === $position->getY()) {
                    $k = 0;
                }

                if ($j >= $position->getY() + 1 + $i - 2) {
                    $k = 3;
                }

                $pos2 = new Vector3();

                for ($l = $position->getX() - $k; $l <= $position->getX() + $k && $flag; ++$l) {
                    for ($i1 = $position->getZ() - $k; $i1 <= $position->getZ() + $k && $flag; ++$i1) {
                        if ($j >= 0 && $j < 256) {
                            $pos2->setComponents($l, $j, $i1);
                            if (!$this->canOverride($worldIn->getBlockAt($pos2->x, $pos2->y, $pos2->z))) {
                                $flag = false;
                            }
                        } else {
                            $flag = false;
                        }
                    }
                }
            }

            if (!$flag) {
                return false;
            } else {
                $down = $position->down();
                $block = $worldIn->getBlockAt($down->x, $down->y, $down->z);

                if (($block === BlockTypeIds::GRASS || $block === BlockTypeIds::DIRT) && $position->getY() < 256 - $i - 1) {
                    $worldIn->setBlockAt($down->x, $down->y, $down->z, BlockTypeIds::DIRT);

                    for ($k1 = $position->getY() - 3 + $i; $k1 <= $position->getY() + $i; ++$k1) {
                        $j2 = $k1 - ($position->getY() + $i);
                        $l2 = 2 - $j2 / 2;

                        for ($j3 = $position->getX() - $l2; $j3 <= $position->getX() + $l2; ++$j3) {
                            $k3 = $j3 - $position->getX();

                            for ($i4 = $position->getZ() - $l2; $i4 <= $position->getZ() + $l2; ++$i4) {
                                $j1 = $i4 - $position->getZ();

                                if (abs($k3) !== $l2 || abs($j1) !== $l2 || $rand->nextBoundedInt(2) !== 0 && $j2 !== 0) {
                                    $blockpos = new Vector3($j3, $k1, $i4);
                                    $id = $worldIn->getBlockAt($blockpos->x, $blockpos->y, $blockpos->z);

                                    if ($id === BlockTypeIds::AIR || $id === BlockTypeIds::OAK_LEAVES || $id === BlockTypeIds::VINE) {
                                        $this->setBlockAndNotifyAdequately($worldIn, $blockpos, VanillaBlocks::OAK_LEAVES());
                                    }
                                }
                            }
                        }
                    }

                    for ($l1 = 0; $l1 < $i; ++$l1) {
                        $up = $position->up($l1);
                        $id = $worldIn->getBlockAt($up->x, $up->y, $up->z);

                        if ($id === BlockTypeIds::AIR || $id === BlockTypeIds::OAK_LEAVES || $id === BlockTypeIds::WATER) {
                            $this->setBlockAndNotifyAdequately($worldIn, $up, VanillaBlocks::OAK_LEAVES());
                        }
                    }

                    for ($i2 = $position->getY() - 3 + $i; $i2 <= $position->getY() + $i; ++$i2) {
                        $k2 = $i2 - ($position->getY() + $i);
                        $i3 = 2 - $k2 / 2;
                        $pos2 = new Vector3();

                        for ($l3 = $position->getX() - $i3; $l3 <= $position->getX() + $i3; ++$l3) {
                            for ($j4 = $position->getZ() - $i3; $j4 <= $position->getZ() + $i3; ++$j4) {
                                $pos2->setComponents($l3, $i2, $j4);

                                if ($worldIn->getBlockAt($pos2->x, $pos2->y, $pos2->z) === BlockTypeIds::OAK_LEAVES) {
                                    $blockpos2 = $pos2->west();
                                    $blockpos3 = $pos2->east();
                                    $blockpos4 = $pos2->north();
                                    $blockpos1 = $pos2->south();

                                    if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockAt($blockpos2->x, $blockpos2->y, $blockpos2->z) === BlockTypeIds::AIR) {
                                        $this->addHangingVine($worldIn, $blockpos2, 8);
                                    }

                                    if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockAt($blockpos3->x, $blockpos3->y, $blockpos3->z) === BlockTypeIds::AIR) {
                                        $this->addHangingVine($worldIn, $blockpos3, 2);
                                    }

                                    if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockAt($blockpos4->x, $blockpos4->y, $blockpos4->z) === BlockTypeIds::AIR) {
                                        $this->addHangingVine($worldIn, $blockpos4, 1);
                                    }

                                    if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockAt($blockpos1->x, $blockpos1->y, $blockpos1->z) === BlockTypeIds::AIR) {
                                        $this->addHangingVine($worldIn, $blockpos1, 4);
                                    }
                                }
                            }
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    private function setBlockAndNotifyAdequately(ChunkManager $world, Vector3 $pos, Block $b): void
    {
        $world->setBlockAt($pos->x, $pos->y, $pos->z, $b->getId());
       // $level->setBlockDataAt($pos->x, $pos->y, $pos->z, $b->getVariant());
    }

    private function addHangingVine(ChunkManager $worldIn, Vector3 $pos): void
    {
        $this->addVine($worldIn, $pos);
        $i = 4;

        for ($pos = $pos->down(); $i > 0 && $worldIn->getBlockAt($pos->x, $pos->y, $pos->z) === BlockTypeIds::AIR; --$i) {
            $this->addVine($worldIn, $pos);
            $pos = $pos->down();
        }
    }

    private function addVine(ChunkManager $worldIn, Vector3 $pos): void
    {
        $this->setBlockAndNotifyAdequately($worldIn, $pos, VanillaBlocks::VINE());
    }

}
