<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RecordVideoTest extends TestCase
{
    use WithFaker;

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

    private function authority_user()
    {
        $response = $this->post('/api/add_role',
                [
                  'name' => $this->name,
                ]);        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    private $adminname;
    private $adminemail;
    private $adminpassword;

    private function admininit()
    {
        $faker = $this->faker;
        $this->adminname = $faker->name;
        $this->adminemail = $faker->name;
        $this->adminpassword = md5($faker->randomNumber())."aW3?";

        $this->oldadminname = $this->adminname;
        $this->oldadminpassword = $this->adminpassword;

    }

    private function adminregist_user()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
                  'name' => $this->adminname,
//                  'email' => $this->adminemail,
                  'password' => $this->adminpassword,
//                  'password_confirmation' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        return $response;
    }

    private function adminlogin_user()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->adminname,
               'password' => $this->adminpassword,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->token = $response['access_token'];
        return $response;
    }

    private function adminlogin_olduser()
    {
        $response = $this->post('/api/login',
            [
               'name' => $this->oldadminname,
               'password' => $this->oldadminpassword,
            ]);
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $this->admintoken = $response['access_token'];
        return $response;
    }

    private function pwchangeinit()
    {
        $this->adminpassword = $this->adminpassword."aW3?";
    }


    private function changepassword_user()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'name' => $this->adminname,
                  'password' => $this->adminpassword,
        ]);

        return $response;
    }

    public function testRecordVideoApi9_01_01_01()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_02()
    {        
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_03()
    {        
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();
        $this->logout_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_04()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_05()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_06()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_07()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_08()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 2,
                  'item_number' => 10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_09()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 10,
                  'item_number' => 4,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_10()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 40,
                  'item_number' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_11()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_12()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_13()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_14()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 39,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_15()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 2,
                  'item_number' => 10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_16()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 2,
                  'item_number' => 11,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_17()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 2,
                  'item_number' => 12,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_18()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 2,
                  'item_number' => 40,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_19()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 10,
                  'item_number' => 40,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_20()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 1,
                  'item_number' => 40,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_21()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'room_id' => 'room_test',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_22()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'room_id' => 'room_test_m',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_23()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'room_id' => 'fefbuifehwihofew',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_24()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'room_id' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_25()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '2021-01-26',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_26()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '2022-11-26',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_27()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_28()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_end' => '2021-01-26',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_29()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_end' => '2012-10-26',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_30()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_end' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_31()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '2021-01-26',
                  'time_end' => '2021-01-26',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_32()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '2011-01-26',
                  'time_end' => '2011-01-28',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_33()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 10,
                  'time_start' => '',
                  'time_end' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_34()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 100,
                  'sort_type' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_35()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 100,
                  'sort_type' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_36()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 1,
                  'item_number' => 10,
                  'sort_type' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_01_37()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 2,
                  'item_number' => 10,
                  'sort_type' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }






/*
        try
        {
            // ユーザーの取得
            $user = $request->user();
            Log::debug("user", ['User' => $user, 'line' => __LINE__]);

            // 取得できない場合、エラー
            if (!$user) {
                Log::error("get user error", ['request' => $request->all(), 'line' => __LINE__]);
                return response()->json([
                            'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                        ], 400);
            }
        }
        catch(\Exception $e)
        {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
            // Exception Handling
            return response()->json([
                        'result' => '-1',
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                    ], 200);
        }


        try
        {
            if($request->type == 1){
                $query = RecordVideo::where('caller_id', $user->id);
            }else{                
                $query = RecordVideo::where('receiver_id', $user->id);
            }     

            if (!empty($request->room_id)) {
                $query->where('room_id', 'like', '%'.$request->room_id.'%');
            }
            if (!empty($request->time_start)) {
                $query->where('record_start', '>=', $request->time_start." 00:00:00");
            }
            if (!empty($request->time_end)) {
                $query->where('record_start', '<=', $request->time_end." 23:59:59");
            }
            if (!empty($request->sort_type)) {
                $query->orderBy('record_start', 'ASC');
            }else{
                $query->orderBy('record_start', 'DESC');
            }

            if (!empty($request->page_number) && !empty($request->item_number)) {
                $recordvideos_total = $query->count();
                $recordvideos = $query->limit($request->item_number)->offset(($request->page_number - 1) * $request->item_number)->get();
            }else{
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Miss parameter!',
                        ], 400);
            }
            

            // 取得できない場合エラー
            if (!$recordvideos) {
                return response()->json([
                    'result' => '-1',
                    'error_code' => '400',
                    'error_message' => 'Bad Request',
                        ], 400);
            }


            return json_encode(['result' => 0, 'data' => $recordvideos , 'total' => $recordvideos_total]);
*/


    public function testRecordVideoApi9_01_02_01()
    {
        $this->testRecordVideoApi9_01_01_01();
    }

    public function testRecordVideoApi9_01_02_02()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo2', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_02_03()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(405);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_02_04()
    {
        $this->testRecordVideoApi9_01_01_01();
    }

    public function testRecordVideoApi9_01_02_05()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo?type=1&page_number=1&item_number=10', [
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_02_06()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->asForm()->get('http://127.0.0.1:8000/api/recordvideo', [
                'type' => 1,
                'page_number' => 1,
                'item_number' => 1000,
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "0");

        print_r($response);
    }

    public function testRecordVideoApi9_01_02_07()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_02_08()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $image = file_get_contents('/home/saver/work/app8/app8/tests/Feature/photo.jpg');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->withBody(
            base64_encode($image), 'image/jpeg'
        )->get('http://127.0.0.1:8000/api/recordvideo', [
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 400);
        $this->assertEquals($response['result'], "-1");

        print_r($response);
    }

    public function testRecordVideoApi9_01_02_09()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        // 送信データ
        $data = array(
                'type' => 1,
                'page_number' => 1,
                'item_number' => 1000,
        );

        // JSON形式に変換
        $data = json_encode($data);

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Content-Type: application/json; charset=UTF-8; Authorization: Bearer '.$this->token,
                'content' => $data
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);        

        try
        {
            // POST送信
            $ret = file_get_contents('http://127.0.0.1:8000/api/recordvideo', false, $context);
            print_r($ret);
        }
        catch(\Exception $e)
        {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
        }

    }

    public function testRecordVideoApi9_01_03_01()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
//                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_02()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
//                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_03()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
//                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_04()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_05()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => 0,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_06()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => -1,
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_07()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "a",
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_08()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "!",
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_09()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "0;SELECT * FROM users;",
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_10()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "0;DELETE FROM `users` WHERE (`id` = '6');",
                  'page_number' => 1,
                  'item_number' => 1000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_11()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'room_id' => "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-01234567890123456789",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_12()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'room_id' => "room_test;SELECT * FROM users;",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_13()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'room_id' => "room_test;DELETE FROM `users` WHERE (`id` = '6');",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_14()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'room_id' => "漢字",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_15()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_start' => "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-01234567890123456789",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_16()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_start' => "2021-01-26;SELECT * FROM users;",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_17()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_start' => "2021-01-26;DELETE FROM `users` WHERE (`id` = '6');",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_18()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_start' => "漢字",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_19()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_end' => "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-01234567890123456789",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_20()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_end' => "2021-01-26;SELECT * FROM users;",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_21()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_end' => "2021-01-26;DELETE FROM `users` WHERE (`id` = '6');",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_22()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'time_end' => "漢字",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_23()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'sort_type' => "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-01234567890123456789",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_24()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'sort_type' => "2021-01-26;SELECT * FROM users;",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_25()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'sort_type' => "2021-01-26;DELETE FROM `users` WHERE (`id` = '6');",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_03_26()
    {
        $this->init();
        $this->name = 'test1';
        $this->password = 'testtest!0T';
        $this->login_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/recordvideo', [
                  'type' => "1",
                  'page_number' => 1,
                  'item_number' => 1000,
                  'sort_type' => "漢字",
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testRecordVideoApi9_01_04_01()
    {
        $this->testRecordVideoApi9_01_01_01();
    }

    public function testRecordVideoApi9_01_04_02()
    {
        $this->testRecordVideoApi9_01_02_07();
    }

    public function testRecordVideoApi9_01_04_03()
    {
        $this->testRecordVideoApi9_01_01_03();
    }

    public function testRecordVideoApi9_01_04_04()
    {
        $this->testRecordVideoApi9_01_02_02();
    }


}
