<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function testDummyTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
/*    
    public function testRegister()
    {
	    $response = $this->post('/api/register',
		   [
			   'name' => 'testname1',
			   'email' => 'test1333@test.com',
			   'password' => 'testtest',
			   'password_confirmation' => 'testtest',
	        ]);
//	    print_r($response); 
        $response->dumpHeaders();
        $response->dump();
//	    $response->assertStatus(200);
	    $response->assertStatus(422);
    }
*/

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testFakerRegister()
    {
		$faker = $this->faker;

		$password = "testtest";//md5($faker->randomNumber());
//print($faker->email);
	    $response = $this->post('/api/register',
		   [
			   'name' => $faker->name,
			   'email' => $faker->email,
			   'password' => $password,
			   'password_confirmation' => $password,
	        ]);
//	    print_r($response); 
//        $response->dumpHeaders();
//        $response->dump();
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

    }


}
