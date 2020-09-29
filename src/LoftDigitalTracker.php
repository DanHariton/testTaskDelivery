<?php

namespace testTaskDelivery;

use Exception;

class LoftDigitalTracker
{
    /** @var DeliveryNote[] */
    private $notes;

    /**
     * LoftDigitalTracker constructor.
     * @param array|DeliveryNote[] $deliveryNotes List of delivery notes
     */
    public function __construct(array $deliveryNotes)
    {
        $this->notes = $this->reorder($deliveryNotes);
    }

    /**
     * @return array|DeliveryNote[]
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * LoftDigitalTracker constructor.
     * @param array|DeliveryNote[] $deliveryNotes List of delivery notes
     * @return DeliveryNote[]
     * @throws Exception
     */
    private function reorder(array $deliveryNotes)
    {
        /** @var $start DeliveryNote */
        /** @var $end DeliveryNote */
        [$start, $map, $end] = $this->generateTreeMap($deliveryNotes);

        if (!$this->isMapValid($start, $map, $end)) {
            // Can be merged with while, but readability will be lost
            // So additional O(n)
            throw new Exception('Broken chain between all the legs of the trip!');
        }

        $orderedList = [$start];
        $leaf = $start;
        while ($leaf->getGuid() != $end->getGuid()) {
            $leaf = $map[$leaf->getGuid()]['children'];
            $orderedList[] = $leaf;
        }

        return $orderedList;
    }

    private function generateTreeMap($deliveryNotes)
    {
        $map = [];
        $start = null;
        $end = null;

        foreach ($deliveryNotes as $deliveryNoteRoot) {
            $map[$deliveryNoteRoot->getGuid()] = ['parent' => null, 'children' => null];

            foreach ($deliveryNotes as $deliveryNoteChildren) {
                if ($deliveryNoteChildren->getTo() === $deliveryNoteRoot->getFrom()) {
                    $map[$deliveryNoteRoot->getGuid()]['parent'] = $deliveryNoteChildren;
                }

                if ($deliveryNoteChildren->getFrom() === $deliveryNoteRoot->getTo()) {
                    $map[$deliveryNoteRoot->getGuid()]['children'] = $deliveryNoteChildren;
                }
            }

            if (!$map[$deliveryNoteRoot->getGuid()]['parent'] && $map[$deliveryNoteRoot->getGuid()]['children']) {
                $start = $deliveryNoteRoot;
            }

            if ($map[$deliveryNoteRoot->getGuid()]['parent'] && !$map[$deliveryNoteRoot->getGuid()]['children']) {
                $end = $deliveryNoteRoot;
            }
        }

        return [$start, $map, $end];
    }

    private function isMapValid($start, array $map, $end)
    {
        if (!($start instanceof DeliveryNote) || !($end instanceof DeliveryNote)) {
            return false;
        }

        $countOfParentAndNonChildren = 0;
        $countOfChildrenAndNonParent = 0;
        $countOfNull = 0;

        foreach ($map as $item) {
            if ($item['parent'] && !$item['children']) {
                $countOfParentAndNonChildren++;
            }

            if (!$item['parent'] && $item['children']) {
                $countOfChildrenAndNonParent++;
            }

            if (!$item['parent'] && !$item['children']) {
                $countOfNull++;
            }
        }

        // Map have only start and end but those mismatch each other.
        if (count($map) == 2 && $map[$start->getGuid()]['children']->getGuid() !== $end->getGuid()) {
            return false;
        }

        return $countOfParentAndNonChildren === 1 && $countOfChildrenAndNonParent === 1 && $countOfNull === 0;
    }
}