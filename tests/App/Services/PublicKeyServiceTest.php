<?php

namespace Tests\App\Services;

use App\Services\PublicKeyService;
use PHPUnit\Framework\TestCase;

class PublicKeyServiceTest extends TestCase
{
    private PublicKeyService $testad;

    public function setup(): void
    {
        $this->testad = new PublickeyService();
    }

    public function testRequest()
    {
        $result = $this->testad->create();
        TestCase::assertTrue(isset($result["public_key"]));
    }
}
