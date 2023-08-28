<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AdminRegisterTest extends TestCase
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
    public function testAdminRegisterApi6_01_01_1()
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
//                  'email' => $this->adminemail,
                  'password' => $this->adminpassword,
//                  'password_confirmation' => $this->adminpassword,
        ]);
/*
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
*/
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

    public function testAdminRegisterApi6_01_01_01()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();
        $response = $this->adminregist_user();
/*
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
                  'name' => $this->adminname,
                  'email' => $this->adminemail,
                  'password' => $this->adminpassword,
                  'password_confirmation' => $this->adminpassword,
        ]);
*/
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_01_02()
    {
        $this->admininit();
        $response = $this->adminregist_user();
        
        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_01_03()
    {
        $this->init();
        $this->regist_user();
        $this->login_user();

        $this->admininit();
        $response = $this->adminregist_user();

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_02_01()
    {
        $this->testAdminRegisterApi6_01_01_01();
    }

    public function testAdminRegisterApi6_01_02_02()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister2', [
                  'name' => $this->adminname,
//                  'email' => $this->adminemail,
                  'password' => $this->adminpassword,
//                  'password_confirmation' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_02_03()
    {
        $this->testAdminRegisterApi6_01_01_01();
    }

    public function testAdminRegisterApi6_01_02_04()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/AdminRegister', [
                  'name' => $this->adminname,
//                  'email' => $this->adminemail,
                  'password' => $this->adminpassword,
//                  'password_confirmation' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(405);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_02_05()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister?'.'name='.$this->adminname.'&password='.$this->adminpassword, [
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_02_06()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->asForm()->post('http://127.0.0.1:8000/api/AdminRegister', [
                'name' => $this->adminname,
                'password' => $this->adminpassword,
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "0");

        print_r($response);
    }

    public function testAdminRegisterApi6_01_02_07()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_02_08()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $image = file_get_contents('/home/saver/work/app8/app8/tests/Feature/photo.jpg');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->withBody(
//        $response = Http::withBody(
            base64_encode($image), 'image/jpeg'
        )->post('http://127.0.0.1:8000/api/AdminRegister', [
                'name' => $this->adminname,
                'password' => $this->adminpassword,
        ]);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "-1");

        print_r($response);
    }

    public function testAdminRegisterApi6_01_02_09()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        // 送信データ
        $data = array(
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        );

        // JSON形式に変換
        $data = json_encode($data);

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'POST',
                'header'=> 'Content-type: application/json; charset=UTF-8', //JSON形式で表示
                'content' => $data
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        // POST送信
        $response = file_get_contents('http://127.0.0.1:8000/api/AdminRegister', false, $context);

        $status_code = $response->status();
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "-1");

        print_r($response);
    }

    public function testAdminRegisterApi6_01_03_01()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_02()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_03()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_04()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!78";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_05()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!78123456781234567812345678";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_06()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!781234567812345678123456781234567812345678123456781234";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_07()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_08()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!7";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_09()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!7812345678123456781234567812345678123456781234567812345";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_10()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_11()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-1A3a5!78123456781234567812345678123456781234567812345678123-01234567890123456789";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_12()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3a5!78";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_13()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1A3A5!78";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_14()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1b3a5!78";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_15()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "AAAAaaa!";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_16()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "1b3a5B78";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_17()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "AAAAAAAA";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_18()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "abcdefgh";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_19()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "01234567";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_20()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "!#$%&()[]";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_21()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminpassword = "aB12!323123あ";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();
    }

    public function testAdminRegisterApi6_01_03_22()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = "9";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();
    }

    public function testAdminRegisterApi6_01_03_23()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = "あ";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();
    }

    public function testAdminRegisterApi6_01_03_24()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = "%";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();
    }

    public function testAdminRegisterApi6_01_03_25()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqq3';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();
    }

    public function testAdminRegisterApi6_01_03_26()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = "";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_27()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $this->adminname = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq4';


        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();
    }

    public function testAdminRegisterApi6_01_03_28()
    {
        $this->init();
        $this->regist_user();
        $this->authority_user();
        $this->login_user();

        $this->admininit();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response->dumpHeaders();
        $response->dump();

        $this->adminlogin_user();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('POST', '/api/AdminRegister', [
            'name' => $this->adminname,
            'password' => $this->adminpassword,
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'result' => -1,
            ]);

        $response->dumpHeaders();
        $response->dump();

    }






}
