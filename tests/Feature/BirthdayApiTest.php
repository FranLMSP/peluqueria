<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Employee;
use App\Customer;

class BirthdayApiTest extends TestCase
{
	use RefreshDatabase;
    
    /** @test */
    public function customers_birthdays_of_this_week_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $customers = [];

        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1997-12-17'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1997-9-9'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '2000-2-4'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1890-12-17'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '2004-4-10'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1999-11-7'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1988-9-8'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '2006-1-9'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1850-3-27'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1992-5-28'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1999-7-5'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '2001-4-2'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '2000-2-1'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1997-5-4'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1999-10-10'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1998-12-13'
        ]);
        $customers[] = factory(Customer::class)->create([
            'birthdate' => '1992-11-15'
        ]);

        $newCustomers = [];
        foreach($customers as $row) {
            $birthdate = '2000-'.date('m-d', strtotime($row->birthdate));

            $now = '2000-'.date('m-d');
            $finish = '2000-'.date('m-d', strtotime('+7 days'));

            if(strtotime($birthdate) >= strtotime($now) && strtotime($birthdate) <= strtotime($finish)) {
                $newCustomers[] = [
                    'id'=> $row->id,
                    'identity_number' => $row->identity_number,
                    'names' => $row->names,
                    'surnames' => $row->surnames,
                    'birthdate' => $row->birthdate
                ];
            }

        }

        usort($newCustomers, function ($item1, $item2) {
            $date1 = date('m-d', strtotime($item1['birthdate']));
            $date2 = date('m-d', strtotime($item2['birthdate']));

            return strtotime('2000-'.$date1) <=> strtotime('2000-'.$date2);
        });

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('GET', '/api/customers/birthdays')
        ->assertStatus(200)
        ->assertExactJson([
            'customers' => $newCustomers
        ]);
    }
    /** @test */
    public function employees_birthdays_of_this_week_can_be_listed()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employees = [];

        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1997-12-17'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1997-9-9'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '2000-2-4'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1890-12-17'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '2004-4-10'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1999-11-7'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1988-9-8'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '2006-1-9'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1850-3-27'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1992-5-28'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1999-7-5'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '2001-4-2'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '2000-2-1'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1997-5-4'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1999-10-10'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1998-12-13'
        ]);
        $employees[] = factory(Employee::class)->create([
        	'birthdate' => '1992-11-15'
        ]);

        $newEmployees = [];
       	foreach($employees as $row) {
            $birthdate = '2000-'.date('m-d', strtotime($row->birthdate));

            $now = '2000-'.date('m-d');
            $finish = '2000-'.date('m-d', strtotime('+7 days'));

            if(strtotime($birthdate) >= strtotime($now) && strtotime($birthdate) <= strtotime($finish)) {
                $newEmployees[] = [
                	'id'=> $row->id,
                	'identity_number' => $row->identity_number,
                	'names' => $row->names,
                	'surnames' => $row->surnames,
                	'birthdate' => $row->birthdate
                ];
            }

        }

		usort($newEmployees, function ($item1, $item2) {
			$date1 = date('m-d', strtotime($item1['birthdate']));
			$date2 = date('m-d', strtotime($item2['birthdate']));

		    return strtotime('2000-'.$date1) <=> strtotime('2000-'.$date2);
		});

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/employees/birthdays')
		->assertStatus(200)
		->assertExactJson([
			'employees' => $newEmployees
		]);
    }
}
