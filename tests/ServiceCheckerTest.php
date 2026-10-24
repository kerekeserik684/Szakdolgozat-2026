
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../service_checker.php';

class ServiceCheckerTest extends TestCase
{
    public function testValidService(): void
    {
        $service = [
            'service_entries' => 3,
            'service_name' => 'Személyi edzés',
            'service_price' => 5000
        ];

        $result = checkService($service);

        $this->assertTrue($result['success']);
        $this->assertSame(
            'Van érvényes szolgáltatása ma: Személyi edzés (5000 Ft)',
            $result['message']
        );
    }

    public function testNoValidService(): void
    {
        $result = checkService(null);

        $this->assertFalse($result['success']);
        $this->assertSame(
            'Nincs érvényes szolgáltatása a mai napra.',
            $result['message']
        );
    }

    public function testServiceWithZeroEntries(): void
    {
        $service = [
            'service_entries' => 0,
            'service_name' => 'Személyi edzés',
            'service_price' => 5000
        ];

        $result = checkService($service);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString(
            'nincs több felhasználható alkalom',
            $result['message']
        );
    }

    public function testServiceWithNullEntries(): void
    {
        $service = [
            'service_entries' => null,
            'service_name' => 'Havi bérlet',
            'service_price' => 15000
        ];

        $result = checkService($service);

        $this->assertTrue($result['success']);
    }
}
