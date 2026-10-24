
<?php

function checkService(?array $service): array
{
    if ($service === null) {
        return [
            'success' => false,
            'message' => 'Nincs érvényes szolgáltatása a mai napra.'
        ];
    }

    if (
        $service['service_entries'] !== null
        && $service['service_entries'] < 1
    ) {
        return [
            'success' => false,
            'message' => 'A szolgáltatás lejárt (nincs több felhasználható alkalom).'
        ];
    }

    return [
        'success' => true,
        'message' => 'Van érvényes szolgáltatása ma: '
            . $service['service_name']
            . ' (' . $service['service_price'] . ' Ft)'
    ];
}
