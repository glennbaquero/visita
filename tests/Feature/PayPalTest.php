<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PRAXXYSEcommerce\PayPal\Facades\PRXPayPal;

class PayPalTest extends TestCase
{
    /**
     * Test config
     *
     * @return void
     */
    public function testSettings()
    {
        $this->assertTrue(PRXPayPal::settings(), 'Please check your PRX_PAYPAL settings in your .env file.');
    }
}
