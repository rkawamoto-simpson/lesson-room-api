<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LogoutTest extends TestCase
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
/*
    public function testLogoutOnly()
    {
        $token = "441|pdZwPtKbua0q8lIPpFITU34poz4vQJtVsNYIzCEi";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
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
        $this->user_id = "";
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

//      print_r($response); 
//        $response->dumpHeaders();
//        $response->dump();
//     $array = json_decode($response, true);

//      Log::debug("json", ['response' => print_r($response, true), 'dump' => $response->dump()]);
        $data = $response->decodeResponseJson()->json();
        $result = $data['result'];
        $user = $data['user'];
        $user_id = $user['id'];
//        $decodedResponse = $testJson->json();

        $this->user_id = $user_id;

//      Log::debug("a", ['b' => $a, 'line' => __LINE__]);

//      Log::debug("json", ['dump' => $response->dump(), 'resposne' => $response]);
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

        $this->token = $response['access_token'];
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

        $this->token = $response['access_token'];
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

        $this->token1 = $response['access_token'];
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

        $this->token2 = $response['access_token'];
        return $response;
    }

    private function login_user_and_device1()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name1,
               'password' => $this->password1,
               'device_id' => $this->device_id1,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token1 = $response['access_token'];
        return $response;
    }

    private function login_user_and_device2()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->name2,
               'password' => $this->password2,
               'device_id' => $this->device_id2,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token2 = $response['access_token'];
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

    public function testLogoutApi2_01_01_01()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->logout_user();
    }

    public function testLogoutApi2_01_01_02()
    {
        $this->init();
        $this->regist_user();
        $this->login_user_and_device();

        $this->logout_user();
    }

    public function testLogoutApi2_01_01_03()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user1();

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->logout_user1();
        $this->logout_user2();
    }

    public function testLogoutApi2_01_01_04()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user1();

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->logout_user2();
        $this->logout_user1();
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

    public function testLogoutApi2_01_01_05()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user_and_device1();

        $this->init2();
        $this->regist_user2();
        $this->login_user_and_device2();

        $this->logout_user1();
        $this->logout_user2();
    }

    public function testLogoutApi2_01_01_06()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user1();

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->logout_user1();
    }

    public function testLogoutApi2_01_01_07()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user_and_device1();

        $this->init2();
        $this->regist_user2();
        $this->login_user_and_device2();

        $this->logout_user1();
    }

    public function testLogoutApi2_01_01_08()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user1();

        $this->init2();
        $this->regist_user2();
        $this->login_user2();

        $this->logout_user2();
    }

    public function testLogoutApi2_01_01_09()
    {
        $this->init1();
        $this->regist_user1();
        $this->login_user_and_device1();

        $this->init2();
        $this->regist_user2();
        $this->login_user_and_device2();

        $this->logout_user2();
    }

    public function testLogoutApi2_01_01_10()
    {
        $this->init();
        $this->regist_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testLogoutApi2_01_01_11()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->logout_user();

/*
        $id = null;
        $token = $this->token;
        Log::debug("token", ['token' => $token, 'line' => __LINE__]);
        if (strpos($token, '|') === false) {
            $token = hash('sha256', $token);
        Log::debug("token", ['token' => $token, 'line' => __LINE__]);
        } else {
            [$id, $token] = explode('|', $token, 2);
        Log::debug("id", ['id' => $id, 'line' => __LINE__]);
        Log::debug("token", ['token' => $token, 'line' => __LINE__]);
            $token = hash('sha256', $token);
        Log::debug("token", ['token' => $token, 'line' => __LINE__]);
        }


//        $token = hash('sha256', $this->token);
        Log::debug("id", ['id' => $id, 'line' => __LINE__]);
        Log::debug("token", ['token' => $token, 'line' => __LINE__]);
        Log::debug("user", ['user_id' => $this->user_id, 'line' => __LINE__]);
*/

//        $this->logout_user();
/*
        $this->assertDatabaseHas('personal_access_tokens', [
//            'name' => $this->device_id,
            'tokenable_id' => $this->user_id,
            'token' => $token,
//            'deleted_at' => null
        ]);
*/


        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);


    }
/*
    public function testLogoutApi2_01_01_011b()
    {
        Log::debug("token", ['Token' => $this->token, 'line' => __LINE__]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(500);
    }

    public function testLogoutApi2_01_01_011c()
    {
        $this->token = "665|zAkHJq9Y4oeMRHY0AOCTajDgUimyxoconFIXJfG8";
        Log::debug("token", ['Token' => $this->token, 'line' => __LINE__]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(500);
    }
*/
    public function testLogoutApi2_01_01_12()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->logout_user();

        $this->login_user();
    }

    public function testLogoutApi2_01_01_13()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->logout_user();

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

    public function testLogoutApi2_01_01_14()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->logout_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testLogoutApi2_01_01_15()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        // トークン期限切れ後にcurlでログアウト実行
    }

    public function testLogoutApi2_01_01_16()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->token = "441|pdZwPtKbua0q8lIPpFITU34poz4vQJtVsNYIzCEi";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testLogoutApi2_01_01_17()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->token = "";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logout', []);

        $response->dump();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);
    }

    public function testLogoutApi2_01_01_18()
    {
        $this->init();
        $this->regist_user();

        $repeat = 100;
        for($i = 0; $i < $repeat; $i++) {
            Log::debug("---------------start ", ['No' => $i]);
            echo "start ".$i;
            echo "\r\n";

            $this->login_user();

            $response = $this->withHeaders([
                'Authorization' => 'Bearer '.$this->token,
            ])->json('POST', '/api/logout', []);

            $response->dumpHeaders();
            $response->dump();
            
            $response
                ->assertStatus(200)
                ->assertJson([
                    'result' => 0,
                ]);

            echo "end ".$i;
            echo "\r\n";
        }

    }


}
