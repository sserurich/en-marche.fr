<?php

namespace AppBundle\Summary;

class SummaryItemDisplayOrderer
{
    public static function updateItemPosition(iterable $collection, SummaryItemPositionableInterface $updatedItem, int $currentItemPosition, ?int $newItemPosition): void
    {
        $newItemPosition = $newItemPosition ?: $currentItemPosition;

        if (1 < count($collection) && $currentItemPosition !== $newItemPosition) {
            foreach ($collection as $item) {
                if ($updatedItem === $item) {

                }
                if (!$item instanceof SummaryItemPositionableInterface) {
                    throw new \InvalidArgumentException(sprintf('Expected instance of "%s", got "%s".', SummaryItemPositionableInterface::class, is_object($item) ? get_class($item) : gettype($item)));
                }

                $itemPosition = $item->getDisplayOrder();
                if ($itemPosition < $currentItemPosition) {
                    if ($itemPosition >= $newItemPosition) {
                        $item->setDisplayOrder(++$itemPosition);
                    }
                    continue;
                }

                if ($itemPosition <= $newItemPosition) {
                    $item->setDisplayOrder(--$itemPosition);
                }
            }
        }
    }
}
