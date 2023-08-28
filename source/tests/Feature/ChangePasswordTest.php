<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class ChangePasswordTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test login.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->post('/api/login',
           [
               'name' => 'test2',
               'password' => 'testtest',
               'device_id' => 'test',
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);
    }

    public function testLoginOnly()
    {
        $response = $this->post('/api/login',
           [
               'name' => 'test2',
               'password' => 'testtest',
               'device_id' => 'test',
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);
    }

    /**
     * A basic feature test logout.
     *
     * @return void
     */
    public function testLogout()
    {
        $response = $this->post('/api/login',
           [
               'name' => 'test2',
               'password' => 'testtest',
               'device_id' => 'test',
            ]);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    public function testLogoutOnly()
    {
        $token = "441|pdZwPtKbua0q8lIPpFITU34poz4vQJtVsNYIzCEi";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testLogin_bk()
    {
        $faker = $this->faker;
        $name = $faker->name;
        $password = "testtest";//md5($faker->randomNumber());
        $device_id = "device".$faker->randomNumber();

        $response = $this->post('/api/register',
                [
                  'name' => $name,
                  'email' => $faker->email,
                  'password' => $password,
                  'password_confirmation' => $password,
                ]);
//      print_r($response); 
//        $response->dumpHeaders();
//        $response->dump();
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
/*                    
print($name);
print("\r\n");
print($password);
print("\r\n");
print($device_id);
print("\r\n");
*/
        $response = $this->post('/api/login',
            [
               'name' => $name,
               'password' => $password,
               'device_id' => $device_id,
            ]);
//        $response->dumpHeaders();
//        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);


/*            
        $faker = $this->faker;
        $name = "test12312";//$faker->name;
        $password = md5($faker->randomNumber());
        $device_id = $faker->randomNumber();
        print($faker->name);
        print("\r\n");
        print($faker->email);
        print("\r\n");
        print($password);
        print("\r\n");
        $response = $this->post('/api/register',
            [
                'name' => $name,
                'email' => $faker->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $response = $this->post('/api/login',
            [
               'name' => $name,
               'password' => $password,
               'device_id' => $device_id,
            ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
*/

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

    }

/*
    public function testLoginApi1_01_01_1()
    {
        $faker = $this->faker;
        $name = "test21321";//$faker->name;

    $password = "testtest";//md5($faker->randomNumber());
print($faker->email);
      $response = $this->post('/api/register',
       [
         'name' => $name,
         'email' => $faker->email,
         'password' => $password,
         'password_confirmation' => $password,
          ]);
//      print_r($response); 
        $response->dumpHeaders();
        $response->dump();
      $response->assertStatus(200);

        $device_id = $faker->randomNumber();
/*
        print($faker->name);
        print("\r\n");
        print($faker->name);
        print("\r\n");

        $response = $this->post('/api/login',
            [
               'name' => $name,
               'password' => $password,
               'device_id' => $device_id,
            ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
*/
/*            
    }
*/

    private $name;
    private $email;
    private $password;
    private $device_id;
    private $token;

    private $name1;
    private $email1;
    private $password1;
    private $device_id1;
    private $token1;

    private $name2;
    private $email2;
    private $password2;
    private $device_id2;
    private $token2;

    private function init()
    {
        $faker = $this->faker;
        $this->name = $faker->name;
        $this->email = $faker->name;
        $this->password = md5($faker->randomNumber());
        $this->device_id = "device".$faker->randomNumber();
        $this->token = "";
    }

    private function init1()
    {
        $faker = $this->faker;
        $this->name1 = $faker->name;
        $this->email1 = $faker->name;
        $this->password1 = md5($faker->randomNumber());
        $this->device_id1 = "device".$faker->randomNumber();
        $this->token1 = "";
    }

    private function init2()
    {
        $faker = $this->faker;
        $this->name2 = $faker->name;
        $this->email2 = $faker->name;
        $this->password2 = md5($faker->randomNumber());
        $this->device_id2 = "device".$faker->randomNumber();
        $this->token2 = "";
    }

    private function regist_user()
    {
        $response = $this->post('/api/register',
                [
                  'name' => $this->name,
                  'email' => $this->email,
                  'password' => $this->password,
                  'password_confirmation' => $this->password,
                ]);        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    private function regist_user1()
    {
        $response = $this->post('/api/register',
                [
                  'name' => $this->name1,
                  'email' => $this->email1,
                  'password' => $this->password1,
                  'password_confirmation' => $this->password1,
                ]);        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    private function regist_user2()
    {
        $response = $this->post('/api/register',
                [
                  'name' => $this->name2,
                  'email' => $this->email2,
                  'password' => $this->password2,
                  'password_confirmation' => $this->password2,
                ]);        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    private function create_room()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
    }

    private function create_room1()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token1,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
    }

    private function create_room2()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token2,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
    }

    public function testLoginApi1_01_01_1()
    {
        $this->init();
        $this->regist_user();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token = $response['access_token'];

        $this->create_room();
    }

    public function testLoginApi1_01_01_2()
    {
        $this->init();
        $this->regist_user();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token = $response['access_token'];

        $this->create_room();
    }

    public function testLoginApi1_01_01_3()
    {
      for($i = 0; $i < 2; $i++) {
        $this->init();
        $this->regist_user();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token = $response['access_token'];

        $this->create_room();
      }
    }

    public function testLoginApi1_01_01_4()
    {
      for($i = 0; $i < 2; $i++) {
        $this->init();
        $this->regist_user();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token = $response['access_token'];

        $this->create_room();
      }
    }

    public function testLoginApi1_01_01_5()
    {
        $this->init();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(400);
        $this->assertEquals($response['result'], -1);
    }

    public function testLoginApi1_01_01_6()
    {
        $this->init();

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]);
        $response->assertStatus(400);
        $this->assertEquals($response['result'], -1);
    }

    public function testLoginApi1_01_01_7()
    {
        $this->init();
        $this->regist_user();

        $this->name = 'hoge';

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(400);
        $this->assertEquals($response['result'], -1);
    }

    public function testLoginApi1_01_01_8()
    {
        $this->init();
        $this->regist_user();

        $this->password = 'hoge';

        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(400);
        $this->assertEquals($response['result'], -1);
    }

    public function testLoginApi1_01_01_11()
    {
        $this->init1();
        $this->regist_user1();

        $response = $this->post('/api/login',
            [
               'name' => $this->name1,
               'password' => $this->password1,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token1 = $response['access_token'];


        $this->init2();
        $this->regist_user2();

        $response = $this->post('/api/login',
            [
               'name' => $this->name2,
               'password' => $this->password2,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token2 = $this->token1;//$response['access_token'];

        $this->create_room1();
        $this->create_room2();
        
    }

    public function testLoginApi1_01_01_12()
    {
        $this->init();
        $this->regist_user();

        $repeat = 100;
        for($i = 0; $i < $repeat; $i++) {
            Log::debug("---------------start ", ['No' => $i]);
            echo "start ".$i;
            echo "\r\n";

            $response = $this->post('/api/login',
                [
                   'name' => $this->name,
                   'password' => $this->password,
                ]);

            $response->dumpHeaders();
            $response->dump();

            $response->assertStatus(200);
            $this->assertEquals($response['result'], 0);

            echo "end ".$i;
            echo "\r\n";
        }

    }




}
