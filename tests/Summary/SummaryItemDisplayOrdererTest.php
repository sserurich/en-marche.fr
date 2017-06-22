<?php

namespace Tests\AppBundle\Summary;

use AppBundle\Summary\SummaryItemDisplayOrderer;
use AppBundle\Summary\SummaryItemPositionableInterface;
use PHPUnit\Framework\TestCase;

class SummaryItemDisplayOrdererTest extends TestCase
{
    public function testSortDoesNotOrderIfThereIsOnlyOneItem()
    {
        $item = $this->createDummyItem(1, false);

        SummaryItemDisplayOrderer::updateItemPosition([$item], $item, 1, 1);
    }

    private function createDummyItem(int $position, bool $willBeChecked = true, bool $willBeOrdered = false, int $newPosition = null): SummaryItemPositionableInterface
    {
        $mock = $this->createMock(SummaryItemPositionableInterface::class);

        if ($willBeChecked) {
            $mock->expects($this->once())->method('getDisplayOrder')->willReturn($position);
        } else {
            $mock->expects($this->never())->method('getDisplayOrder');
        }

        if ($willBeOrdered) {
            $mock->expects($this->once())->method('setPosition')->with($newPosition);
        } else {
            $mock->expects($this->never())->method('getDisplayOrder');
        }

        return $mock;
    }
}
