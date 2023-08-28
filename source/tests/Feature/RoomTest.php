<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class RoomTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateRoom()
    {
        $response = $this->post('/api/login',
           [
               'name' => 'test2',
               'password' => 'testtest',
               'device_id' => 'test',
            ]);

      //print_r($response); 
//        $response->assertStatus(200);
//        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

//        $response->dumpHeaders();
//        $response->dump();
            
    }

    private function testCreateRoomOnly()
    {
        $token = "456|OcEPKkeO3ou2fe8GZ0Rr5fbhg5Bv537j1vS6O9q5";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
    }




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

    private function login_user()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        return $response;
    }

    private function login_user_and_device()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        return $response;
    }

    private function login_user1()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name1,
               'password' => $this->password1,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        return $response;
    }

    private function login_user2()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name2,
               'password' => $this->password2,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        return $response;
    }

    private function logout_user()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        return $response;
    }

    private function logout_user1()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token1,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        return $response;
    }

    private function logout_user2()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token2,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        return $response;
    }

    private function create_room()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/createroom', []);
//$response = $this->withoutMiddleware()->json('GET', '/api/data');

        $response->dumpHeaders();
        $response->dump();

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

    public function testCreateRoomApi3_01_01_01()
    {
        $this->init();
        $this->regist_user();
        $response = $this->login_user();

        $this->token = $response['access_token'];

        $this->create_room();
    }

    public function testCreateRoomApi3_01_01_02()
    {
        $this->init();
        $this->regist_user();
        $response = $this->login_user_and_device();

        $this->token = $response['access_token'];

        $this->create_room();
    }

    public function testCreateRoomApi3_01_01_03()
    {
      for($i = 0; $i < 2; $i++) {
        $this->init();
        $this->regist_user();
        $response = $this->login_user();

        $this->token = $response['access_token'];

        $this->create_room();
      }
    }

    public function testCreateRoomApi3_01_01_04()
    {
      for($i = 0; $i < 2; $i++) {
        $this->init();
        $this->regist_user();
        $response = $this->login_user_and_device();

        $this->token = $response['access_token'];

        $this->create_room();
      }
    }

    private function roomCreate1()
    {
        $this->init();
        $this->regist_user();
        $response = $this->login_user();

        $this->token = $response['access_token'];
    }

    private function roomCreate2(int $repeat)
    {
      for($i = 0; $i < $repeat; $i++) {
        $this->create_room();
      }
    }

    public function testCreateRoomApi3_01_01_05()
    {
        $this->roomCreate1();
        $this->roomCreate2(2);
    }

    public function testCreateRoomApi3_01_01_06()
    {
        $this->roomCreate1();
        $this->roomCreate2(5);
    }

    public function testCreateRoomApi3_01_01_07()
    {
        $this->roomCreate1();
        $this->roomCreate2(10);
    }

    public function testCreateRoomApi3_01_01_08()
    {
        $this->init();

        $this->token = "";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/createroom', []);
        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testCreateRoomApi3_01_01_09()
    {
        $this->init();

        $this->token = "37d94ddd9c57cf65914f5c52427e0d7eb725bc5d7e5126230d96d8a8f08dfdf8";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/createroom', []);
        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testCreateRoomApi3_01_01_11()
    {
        $this->init();
        $this->regist_user();
        $response = $this->login_user();

        $this->token = $response['access_token'];
        $this->logout_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/createroom', []);
//      print_r($response); 
//        $response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testCreateRoomApi3_01_01_12()
    {
        $this->init1();
        $this->regist_user1();
        $response = $this->login_user1();

        $this->token1 = $response['access_token'];

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->token2 = $response['access_token'];

        $this->create_room1();
        $this->create_room2();
        
    }

    public function testCreateRoomApi3_01_01_13()
    {
        $this->init1();
        $this->regist_user1();
        $response = $this->login_user1();

        $this->token1 = $response['access_token'];

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->token2 = $this->token1;//$response['access_token'];

        $this->create_room1();
        $this->create_room2();
        
    }

    public function testCreateRoomApi3_01_01_14()
    {
        $this->init();
        $this->regist_user();
        $response = $this->login_user();

        $this->token = $response['access_token'];

        $repeat = 100;
        for($i = 0; $i < $repeat; $i++) {
            Log::debug("---------------start ", ['No' => $i]);
            echo "start ".$i;
            echo "\r\n";
            $this->create_room();            
            echo "end ".$i;
            echo "\r\n";
        }
    }

    public function testCreateRoomApi3_01_01_15()
    {
        $repeat = 100;
        for($i = 0; $i < $repeat; $i++) {
            $this->init();
            $this->regist_user();
            $response = $this->login_user();

            $this->token = $response['access_token'];

            Log::debug("---------------start ", ['No' => $i]);
            echo "start ".$i;
            echo "\r\n";
            $this->create_room();            
            echo "end ".$i;
            echo "\r\n";
        }
    }



}
