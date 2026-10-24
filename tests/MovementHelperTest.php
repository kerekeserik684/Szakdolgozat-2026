
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../movement_helper.php';

class MovementHelperTest extends TestCase
{
    private array $product = [
        'scoop_volume' => 2,
        'quantity_price' => 1000,
        'order_price' => 10000,
        'minimum_order_qty' => 20
    ];

    public function testConsumptionPrice(): void
    {
        $movement = [
            'reason' => 'Fogyás',
            'quantity' => 4
        ];

        $this->assertEquals(
            2000.0,
            calculateMovementPrice($movement, $this->product)
        );
    }

    public function testInventoryCorrectionPrice(): void
    {
        $movement = [
            'reason' => 'Leltárkorrekció',
            'quantity' => 3
        ];

        $this->assertEquals(
            3000.0,
            calculateMovementPrice($movement, $this->product)
        );
    }

    public function testDisposalPrice(): void
    {
        $movement = [
            'reason' => 'Selejtezés',
            'quantity' => 2
        ];

        $this->assertEquals(
            2000.0,
            calculateMovementPrice($movement, $this->product)
        );
    }

    public function testPurchasePrice(): void
    {
        $movement = [
            'reason' => 'Beszerzés',
            'quantity' => 5
        ];

        $this->assertEquals(
            2500.0,
            calculateMovementPrice($movement, $this->product)
        );
    }

    public function testConsumptionIsRed(): void
    {
        $this->assertSame('red', getMovementColor('Fogyás'));
    }

    public function testPurchaseIsGreen(): void
    {
        $this->assertSame('green', getMovementColor('Beszerzés'));
    }

    public function testZeroScoopVolumeIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $product = $this->product;
        $product['scoop_volume'] = 0;

        calculateMovementPrice([
            'reason' => 'Fogyás',
            'quantity' => 4
        ], $product);
    }
}
