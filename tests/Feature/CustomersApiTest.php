<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Customer;
use Illuminate\Support\Facades\DB;

class CustomersApiTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function temp_test() {
		$this->assertTrue(true);
	}

}
