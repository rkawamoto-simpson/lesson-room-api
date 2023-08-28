<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LogCollectionTest extends TestCase
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
    }

    private function adminregist_user()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
                  'name' => $this->adminname,
                  'password' => $this->adminpassword,

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

    private function sendLogCollection()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        return $response;
    }

    private function sendLogCollection_sort_1()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response->assertStatus(200);

        return $response;
    }

    private function sendLogCollection_sort_2()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response->assertStatus(200);
        return $response;
    }




    public function testLogCollectionApi8_01_01_01()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();
        
        $response = $this->sendLogCollection_sort_1();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_02()
    {
        $response = $this->sendLogCollection();

        $response
            ->assertStatus(401)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();        
    }

    public function testLogCollectionApi8_01_01_03()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'Zlla!ts',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_04()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device241',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_05()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device772',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_06()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device2',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

    }

    public function testLogCollectionApi8_01_01_07()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'testtest',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_08()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device5',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_09()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name' => 'device_id',
               'item'=>5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();             
    }

    public function testLogCollectionApi8_01_01_10()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device241',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>1,               
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_11()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device2021',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_12()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device0129',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_13()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'device772',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'page'=>10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_14()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'room_id',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_15()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'room_id',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_16()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'device_id',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_17()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'device_id',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_18()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'created_at',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_19()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'created_at',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_20()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'updated_at',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_21()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'updated_at',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_22()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_23()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_24()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_25()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_26()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'item' => 9,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_01_27()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'item' => 11,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_28()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'item' => 100,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_29()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'item' => 0,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_29_2()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'item' => 0,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_30()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_01_30_2()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_02_01()
    {
        $this->testLogCollectionApi8_01_01_01();
    }

    public function testLogCollectionApi8_01_02_02()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection2',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_02_03()
    {
        $this->testLogCollectionApi8_01_01_01();
    }
        

    public function testLogCollectionApi8_01_02_04()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(405);

        $response->dumpHeaders();
        $response->dump();
    }
    public function testLogCollectionApi8_01_02_05()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection?'.'room_id='.''.'&device_id='.''.'&created_at='.''.'&updated_at='.''.'&sort='.'1',[
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();      
    }

    public function testLogCollectionApi8_01_02_06()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

         $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->asForm()->post('http://127.0.0.1:8000/api/logcollection', [
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);

        print_r($response);        
    }
    public function testLogCollectionApi8_01_02_07()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();           
    }

    public function testLogCollectionApi8_01_02_08()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        //$image = file_get_contents('/home/saver/work/app8/app8/tests/Feature/photo.jpg');
        $image = file_get_contents('/mnt/c/test1/tests/Feature/photo.jpg');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->withBody(
            base64_encode($image), 'image/jpeg'
        )->post('http://127.0.0.1:8000/api/logcollection', [
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);       
        $this->assertEquals($response['result'], "-1");

        print_r($response);        
    }

    public function testLogCollectionApi8_01_02_09()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        // 送信データ
        $data = array(
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        );

        // JSON形式に変換
        $data = json_encode($data);

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'POST',
                'header'=> 'Content-Type: application/x-www-form-urlencoded; Authorization: Bearer '.$this->token,
                'content' => $data
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        try
        {
            // POST送信
            $response = file_get_contents('http://127.0.0.1:8000/api/logcollection', false, $context);
        }
        catch(\Exception $e)
        {
            Log::error("Exception", ['ExceptionMessage' => $e->getMessage(), 'ExceptionCode' => $e->getCode(), 'line' => __LINE__]);
            Log::debug("Exception", ['Exception' => $e]);
        }
    }

    public function testLogCollectionApi8_01_03_01()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => 'db24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a2191',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();        
    }

    public function testLogCollectionApi8_01_03_02()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'device_id' => 'testtest',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();   
    }

    public function testLogCollectionApi8_01_03_03()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'created_at' => '2020-11-18 07:03:05',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();  
    }

    public function testLogCollectionApi8_01_03_04()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'updated_at' => '2020-11-18 07:03:05',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump(); 
    }

    public function testLogCollectionApi8_01_03_05()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'sort' => '1',
        ]);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump(); 
    }

    public function testLogCollectionApi8_01_03_06()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'sort_name' => 'room_id',
        ]);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump(); 
    }

    public function testLogCollectionApi8_01_03_07()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'item' => '1',
        ]);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump(); 
    }

    public function testLogCollectionApi8_01_03_08()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();  
    }

    public function testLogCollectionApi8_01_03_09()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'device_id',
               'item' => 12,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_10()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => 'db24ff635d0d4e60d52e43f46c024aedb24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a2191f3db24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a21910bdb24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a21914877f299b5682423293a1d45a219',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_11()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => 'db24ff635d0d4e60d52e43f46c024aedb24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a2191f3db24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a21910bdb24ff635d0d4e60d52e43f46c024aef30b4877f299b5682423293a1d45a21914877f299b5682423293a1d45a219',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_12()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'testtest',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_13()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => 'testtest',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_14()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '2020-11-18 07:03:05',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_15()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '2020-11-18 07:03:05',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_16()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '2020-12-17 08:56:44',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_17()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '2020-12-17 08:56:44',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_18()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'device_id',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_19()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'device_id',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_20()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'test123456',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_21()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'test123456',
               'item' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_22()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_23()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_24()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '2020-11-18 07:03:05',
               'sort' => '3',
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testLogCollectionApi8_01_03_25()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '1',
               'sort_name'=>'',
               'item' => 5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_03_26()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $this->adminregist_user();
        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/logcollection',[
               'room_id' => '',
               'device_id' => '',
               'created_at' => '',
               'updated_at' => '',
               'sort' => '2',
               'sort_name'=>'',
               'item' => 5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();               
    }

    public function testLogCollectionApi8_01_04_01()
    {
        $this->testLogCollectionApi8_01_01_01();
    }

    public function testLogCollectionApi8_01_04_02()
    {
        $this->testLogCollectionApi8_01_03_24();
    }

    public function testLogCollectionApi8_01_04_03()
    {
        $this->testLogCollectionApi8_01_02_02();
    }

    public function testLogCollectionApi8_01_04_04()
    {
        $this->testLogCollectionApi8_01_01_02();
    }
}
