<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class CurrencyTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_convert_usd_to_eur_succesful(): void
    {
        $result = $this->assertEquals(98, (new CurrencyService())->convert(100, 'usd', 'eur'));
    }

    public function test_convert_usd_to_gbp_returns_zero(): void
    {
        $result = $this->assertEquals(0, (new CurrencyService())->convert(100, 'usd', 'gbp'));
    }
}
