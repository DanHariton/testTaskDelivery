<?php

use testTaskDelivery\DeliveryNote;
use testTaskDelivery\LoftDigitalTracker;
use PHPUnit\Framework\TestCase;

final class OrderNoteTest extends TestCase
{
    public function testCheckIsTrueOrderStayTrue(): void
    {
        $trueOrderedList = [
            new DeliveryNote(
                'Truck',
                'Fazenda São Francisco Citros, Brazil',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Correios'
            ),
            new DeliveryNote(
                'Flight',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Brazil to Porto International Airport, Portugal',
                'LATAM'
            ),
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
            new DeliveryNote(
                'Flight',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'London Heathrow, UK',
                'DHL'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
        ];

        $notOrderedList = [
            new DeliveryNote(
                'Truck',
                'Fazenda São Francisco Citros, Brazil',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Correios'
            ),
            new DeliveryNote(
                'Flight',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Brazil to Porto International Airport, Portugal',
                'LATAM'
            ),
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
            new DeliveryNote(
                'Flight',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'London Heathrow, UK',
                'DHL'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
        ];

        $tracker = new LoftDigitalTracker($notOrderedList);

        $orderedList = $tracker->getNotes();

        foreach ($trueOrderedList as $index => $trueOrderNote) {
            $this->assertTrue(DeliveryNote::compare($trueOrderNote, $orderedList[$index]));
        }
    }

    public function testCheckIsRandomOrderStayTrue(): void
    {
        $trueOrderedList = [
            new DeliveryNote(
                'Truck',
                'Fazenda São Francisco Citros, Brazil',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Correios'
            ),
            new DeliveryNote(
                'Flight',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Brazil to Porto International Airport, Portugal',
                'LATAM'
            ),
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
            new DeliveryNote(
                'Flight',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'London Heathrow, UK',
                'DHL'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
        ];

        $notOrderedList = [
            new DeliveryNote(
                'Flight',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'London Heathrow, UK',
                'DHL'
            ),
            new DeliveryNote(
                'Flight',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Brazil to Porto International Airport, Portugal',
                'LATAM'
            ),
            new DeliveryNote(
                'Truck',
                'Fazenda São Francisco Citros, Brazil',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Correios'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
        ];

        $tracker = new LoftDigitalTracker($notOrderedList);

        $orderedList = $tracker->getNotes();

        foreach ($trueOrderedList as $index => $trueOrderNote) {
            $this->assertTrue(DeliveryNote::compare($trueOrderNote, $orderedList[$index]));
        }
    }

    public function testBrokenChainThrow(): void
    {
        $trueOrderedList = [
            new DeliveryNote(
                'Truck',
                'Fazenda São Francisco Citros, Brazil',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Correios'
            ),
            new DeliveryNote(
                'Flight',
                'São Paulo–Guarulhos International Airport, Brazil',
                'Brazil to Porto International Airport, Portugal',
                'LATAM'
            ),
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
            new DeliveryNote(
                'Flight',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'London Heathrow, UK',
                'DHL'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
        ];

        $notOrderedList = [
            new DeliveryNote(
                'Van',
                'Brazil to Porto International Airport, Portugal',
                'Adolfo Suárez Madrid–Barajas Airport, Spain',
                'AnyVan'
            ),
            new DeliveryNote(
                'Van',
                'London Heathrow, UK',
                'Loft Digital, London, UK',
                'City Sprint'
            ),
        ];

        $this->expectException(Exception::class);

        $tracker = new LoftDigitalTracker($notOrderedList);
        $orderedList = $tracker->getNotes();

        foreach ($trueOrderedList as $index => $trueOrderNote) {
            $this->assertTrue(DeliveryNote::compare($trueOrderNote, $orderedList[$index]));
        }
    }
}
