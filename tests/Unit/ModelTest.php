<?php

namespace Tests\Unit;

use App\Models\Film;
use Tests\TestCase;

class ModelTest extends TestCase
{
    /**
     * @test
     */
    public function test_that_ticket_price_converted_to_dollars_in_accessor(): void
    {
        $film = new Film();

        $film->setRawAttributes([
            'ticket_price' => 1850
        ]);

        $this->assertEquals(18.50, $film->ticket_price);
    }

    public function test_that_ticket_price_converted_to_cents_in_mutator(): void
    {
        $film = new Film(['ticket_price' => 53.45]);

        $ticketPriceInCents = ($film->getAttributes()['ticket_price']);

        $this->assertEquals(5345, $ticketPriceInCents);
    }
}
