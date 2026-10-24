
<?php

function calculateMovementPrice(
    array $movement,
    array $product
): float {
    $reason = $movement['reason'];
    $quantity = (float) $movement['quantity'];
    $unitPrice = (float) $product['quantity_price'];

    if ($reason === 'Fogyás') {
        $scoopVolume = (float) $product['scoop_volume'];

        if ($scoopVolume <= 0) {
            throw new InvalidArgumentException(
                'Az adagméretnek nullánál nagyobbnak kell lennie.'
            );
        }

        return $quantity / $scoopVolume * $unitPrice;
    }

    if (
        $reason === 'Leltárkorrekció'
        || $reason === 'Selejtezés'
        || $reason === 'Selejt'
    ) {
        return $quantity * $unitPrice;
    }

    $minimumOrderQty = (float) $product['minimum_order_qty'];

    if ($minimumOrderQty <= 0) {
        throw new InvalidArgumentException(
            'A minimális rendelési mennyiségnek nullánál nagyobbnak kell lennie.'
        );
    }

    return (float) $product['order_price']
        / $minimumOrderQty
        * $quantity;
}

function getMovementColor(string $reason): string
{
    return in_array(
        $reason,
        ['Fogyás', 'Leltárkorrekció', 'Selejtezés', 'Selejt'],
        true
    ) ? 'red' : 'green';
}
