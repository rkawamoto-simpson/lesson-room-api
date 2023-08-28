<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

// テスト実行方法
// service mysql start
// php artisan serve
// php artisan test tests/Feature/LoginTest2.php  --filter=testLogin

class LoginTest2 extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test login.
     *
     * @return void
     */
    public function testLogin01_No1()
    {
        //curl -X POST http://127.0.0.1:8000/api/login -d name="test3" -d password="testtest" -d device_id="test1"
        Log::debug("LoginAPI01_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => '',
            ]
        );

        //print_r($response);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->assertStatus(200);
        //$response->dump();
    }

    public function testLogin01_No2()
    {
        Log::debug("LoginAPI01_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'testdate',
            ]
        );
        //print_r($response); 
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin01_No3()
    {
        Log::debug("LoginAPI01_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response); 
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin01_No4()
    {
//curl -X POST http://127.0.0.1:8000/api/login -d name="test3" -d password="testtest" -d device_name="test1"
        Log::debug("LoginAPI01_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        //$response->dump();
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        //print_r($response); 
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin01_No5()
    {
        Log::debug("LoginAPI01_No5");
        //異常系
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        $response->assertStatus(400);
        /*
        $response->assertJsonFragment([
            'result' => "-1",
        ]);*/
        //$response->dump();
    }

    public function testLogin01_No6()
    {
        Log::debug("LoginAPI01_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        //print_r($response); 
        $response->assertStatus(400);
        /*
        $response->assertJsonFragment([
            'result' => "-1",
        ]);*/
        //$response->dump();
    }

    public function testLogin01_No7()
    {
        Log::debug("LoginAPI01_No7");
        //異常系
        $response = $this->post('/api/login',
           [
               'name' => '<script>test3</script>',
               'password' => 'testtest',
            ]
        );
         //print_r($response); 
        $response->assertStatus(400);
        //$response->dump();
    }

    public function testLogin01_No8()
    {
        Log::debug("LoginAPI01_No8");
        //異常系
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => '<script>testtest</script>',
            ]
        );
        //print_r($response); 
        $response->assertStatus(400);
        $response->dump();
    }

    public function testLogin02_No1()
    {
        Log::debug("LoginAPI02_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin02_No2()
    {
        Log::debug("LoginAPI02_No2");
        $response = $this->post('/api/login2',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        //$response->assertStatus(404);
        $response->dumpHeaders();
        $response->dump();

        $response->assertStatus(404);
        $response->assertJsonFragment([
            'result' => '-1',
        ]);
    }

    public function testLogin02_No3()
    {
        Log::debug("LoginAPI02_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
            //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin02_No4()
    {
        Log::debug("LoginAPI02_No4");
        
        $response = $this->get('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

            //print_r($response);
//        $response->dumpHeaders();
//        $response->dump();
        $response->assertStatus(405);
        //$response->dump();
    }

    public function testLogin02_No5()
    {
        Log::debug("LoginAPI02_No5");
        $response = $this->post('/api/login?name=test3&password=testtest',
           [
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dumpHeaders();
//        $response->dump();
    }

    public function testLogin02_No6()
    {
        Log::debug("LoginAPI02_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1234',
            ]
        );
        //print_r($response);        
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin02_No7()
    {
        Log::debug("LoginAPI02_No7");
        $response = $this->post('/api/login',
           [
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
        //$response->dumpHeaders();
    }

    public function testLogin02_No8()
    {
        Log::debug("LoginAPI02_No8");
        $image = file_get_contents('/home/saver/work/app8/app8/tests/Feature/photo.jpg');

        /*
        $response = Http::attach(
            'attachment', $image, 'photo.jpg'
        )->post('http://127.0.0.1/api/login');
        */
        $response = Http::withBody(
            base64_encode($image), 'image/jpeg'
        )->post('http://127.0.0.1:8000/api/login');

//        $response->dumpHeaders();
//        $response->dump();
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "-1");

    }
    
    public function testLogin02_No9()
    {
        Log::debug("LoginAPI02_No9");
        $response = Http::asForm()->post('http://127.0.0.1:8000/api/login', [
               'name' => 'test3',
               'password' => 'testtest',
        ]);


        $status_code = $response->status();

//        $response->dumpHeaders();
//        $response->dump();
        $this->assertEquals($status_code, 200);
        $this->assertEquals($response['result'], "0");
        //print_r($response);
        //$response->dump();     
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


    public function testLogin03_No01()
    {//name
        Log::debug("LoginAPI03_No1");
        $this->init();
        $this->name = '1';
        $this->password = '1';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin03_No02()
    {//name
        Log::debug("LoginAPI03_No2");
        $this->init();
        $this->name = '確認';
        $this->password = '12345678@';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);

        //$response->dump();
    }


    public function testLogin03_No03()
    {//name
        Log::debug("LoginAPI03_No3");
        $this->init();
        $this->name = '!!$$@';
        $this->password = 'admin1234567@123';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin03_No04()
    {//name
        Log::debug("LoginAPI03_No4");
        $this->init();
        $this->name = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq';
        $this->password = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        //$response->dump();
    }

    public function testLogin03_No05()
    {//name
        Log::debug("LoginAPI03_No5");
        $this->init();
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => '',
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        //$response->assertStatus(400);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No06()
    {//name
        Log::debug("LoginAPI03_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'root',
               'password' => '',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");

        $response = $this->post('/api/login',
           [
               'name' => 'root',
               'password' => 'root',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No07()
    {//name
        Log::debug("LoginAPI03_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'admin',
               'password' => '',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");

        $response = $this->post('/api/login',
           [
               'name' => 'admin',
               'password' => 'admin',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No08()
    {//name
        Log::debug("LoginAPI03_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'Administrator',
               'password' => '',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");

        $response = $this->post('/api/login',
           [
               'name' => 'Administrator',
               'password' => 'Administrator',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No09()
    {//name
        Log::debug("LoginAPI03_No9");
        $response = $this->post('/api/login',
           [
               'name' => '漢字',
               'password' => 'admin1234567@123',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No10()
    {//name
        Log::debug("LoginAPI03_No10");
        $response = $this->post('/api/login',
           [
               'name' => '!"#!',
               'password' => 'admin1234567@123',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
    }

    public function testLogin03_No11()
    {//name
        Log::debug("LoginAPI03_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqr',
               'password' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqq',
            ]
        );
        $response->dumpHeaders();
        $response->dump();
        //print_r($response);
        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");
        //$response->dump();
    }

    public function testLogin03_No12()
    {//password
        Log::debug("LoginAPI03_No12");
        $this->init();
        $this->password = '1';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No13()
    {//password
        Log::debug("LoginAPI03_No13");
        $this->init();
        $this->password = '1234567';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No14()
    {//password
        Log::debug("LoginAPI03_No14");
        $this->init();
        $this->password = '12345678';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No15()
    {//password
        Log::debug("LoginAPI03_No15");
        $this->init();
        $this->password = '12345678@';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No16()
    {//password
        Log::debug("LoginAPI03_No16");
        $this->init();
        $this->password = 'admin1234567@123';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No17()
    {//password
        Log::debug("LoginAPI03_No17");
        $this->init();
        $this->password = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => $this->password,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No18()
    {//password
        Log::debug("LoginAPI03_No18");
        $this->init();
        $this->password = 'root2';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => 'root',
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'result' => "-1",
        ]);
    }

    public function testLogin03_No19()
    {//password
        Log::debug("LoginAPI03_No19");
        $this->init();
        $this->password = '漢字2';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => '漢字',
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'result' => "-1",
        ]);
    }

    public function testLogin03_No20()
    {//password
        Log::debug("LoginAPI03_No20");
        $this->init();
        $this->password = '!#!#!%%#2';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => '!#!#!%%#',
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'result' => "-1",
        ]);
    }

    public function testLogin03_No21()
    {//password
        Log::debug("LoginAPI03_No21");
        $this->init();
        $this->password = '123456789012345678901234567890123456789012345678901234567890123456789012';
//        $this->password = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqr';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
                  'name' => $this->name,
                  'password' => '123456789012345678901234567890123456789012345678901234567890123456789012',

//               'password' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqr',
            ]
        );
//        print_r($response);
        print("dumpHeaders");
        print("\r\n");
        $response->dumpHeaders();
        print("dump");
        print("\r\n");
        $response->dump();
        print("\r\n");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No22()
    {
        Log::debug("LoginAPI03_No22");
        $this->init();
        $this->device_id = '1';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No23()
    {
        Log::debug("LoginAPI03_No23");
        $this->init();
        $this->device_id = '確認';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No24()
    {
        Log::debug("LoginAPI03_No24");
        $this->init();
        $this->device_id = '!!"$!"#';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No25()
    {
        Log::debug("LoginAPI03_No25");
        $this->init();
        $this->device_id = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No26()
    {
        Log::debug("LoginAPI03_No26");
        $this->init();
        $this->device_id = '';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "0",
        ]);
    }

    public function testLogin03_No27()
    {
        Log::debug("LoginAPI03_No27");
        $this->init();
        $this->device_id = 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaa88888888888888aaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqp';
        $this->regist_user();
        $response = $this->post('/api/login',
           [
               'name' => $this->name,
               'password' => $this->password,
               'device_id' => $this->device_id,
            ]
        );
        //print_r($response);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'result' => "-1",
        ]);
    }

    public function testLogin04_No1()
    {
        Log::debug("LoginAPI04_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        $response->assertStatus(200);
        //$response->dump();
    }

    public function testLogin04_No2()
    {
        Log::debug("LoginAPI04_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        //print_r($response); 
        $response->assertStatus(200);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        //print_r($response); 
        $response->assertStatus(200);
        //$response->dump();
    }
    public function testLogin04_No3()
    {
        Log::debug("LoginAPI04_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',

            ]
        );

        //print_r($response);
        $response->assertStatus(200);
        //$response->dump();
    }

    public function testLogin04_No4()
    {//name
        Log::debug("LoginAPI04_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'admin',
               'password' => 'admin1234567@123',
            ]
        );
        //print_r($response);
        $response->assertStatus(400);
        //$response->dump();
    }

    public function testLogin04_No6()
    {
        Log::debug("LoginAPI04_No6");
        $response = $this->post('/api/login2',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        $response->assertStatus(404);
        $response->dump();
    }

    public function testLogin04_No7()
    {
        Log::debug("LoginAPI04_No7");
        $response = $this->get('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //print_r($response);
        $response->assertStatus(405);
        //$response->dump();
    }

    public function testLogin04_No8()
    {
        Log::debug("LoginAPI04_No8");
        $response = $this->post('/api/login?name=test3&password=testtest',
           [
            ]
        );
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();
    }

    /**
     * A basic feature test logout.
     *
     * @return void
     */

    public function testLogout01_No1()
    {
        print_r("Logout開始\n");
        //curl -X POST 'http://127.0.0.1:8000/api/logout' -H 'Content-Type: application/json;charset=utf-8' -H 'Authorization: Bearer 2|joNdpTaO38Qy9nxVoAVcdAt3KZPuEW2bT6DH1M04'
        Log::debug("LogoutAPI01_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        $response->dump();
    }

    public function testLogout01_No2()
    {
        Log::debug("LogoutAPI01_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        $response->dump();
        //print_r($response); 
    }

    public function testLogout01_No3()
    {
        Log::debug("LogoutAPI01_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );        
    }

    public function testLogout01_No4()
    {
        Log::debug("LogoutAPI01_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout01_No5()
    {
        Log::debug("LogoutAPI01_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(400);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();      
    }

    public function testLogout01_No6()
    {
        Log::debug("LogoutAPI01_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        $response->assertStatus(400);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);
        //$response->dumpHeaders();
        //$response->dump();      
    }

    public function testLogout01_No7()
    {
        Log::debug("LogoutAPI01_No7");
        $response = $this->post('/api/login',
           [
               'name' => '<script>test3</script>',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
        $response->assertStatus(400);
        $this->assertEquals($response['result'], '-1');

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);    
    }

    public function testLogout01_No8()
    {
        Log::debug("LogoutAPI01_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => '<script>testtest</script>',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
        $response->assertStatus(400);
        $this->assertEquals($response['result'], '-1');

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500); 
    }

    public function testLogout01_No9()
    {
        Log::debug("LogoutAPI01_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);   
       
        //$faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;
       

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => 'testdate',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => 'testdate',
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(200);
    }

    public function testLogout01_No10()
    {
        Log::debug("LogoutAPI01_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);   

        //$faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => 'testdate',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(200);
    }
      

    public function testLogout01_No11()
    {
        Log::debug("LogoutAPI01_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);   


        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(200);
    }



    public function testLogout01_No13()
    {
        Log::debug("LogoutAPI01_No13");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(200);
    }




    public function testLogout02_No1()
    {
        Log::debug("LogoutAPI02_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout02_No2()
    {
        Log::debug("LogoutAPI02_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout2', []);
         $response->assertStatus(404);

        /*
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );*/
        //$response->dumpHeaders();
        $response->dump();
        //print_r($response); 
    }

    public function testLogout02_No3()
    {
        Log::debug("LogoutAPI02_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout02_No4()
    {
        Log::debug("LogoutAPI02_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/logout', []);

         $response->assertStatus(405);

        /*
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );*/
        //$respo
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout02_No9()
    {
        Log::debug("LogoutAPI02_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);
        $token = $response['access_token'];

        $response = $this->withHeaders([
        ])->json('POST', '/api/createroom?Authorization=Bearer '.$token, []);
        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout02_No10()
    {
        Log::debug("LogoutAPI02_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout02_No11()
    {
        Log::debug("LogoutAPI02_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();  
    }

    public function testLogout02_No12()
    {
        Log::debug("LoginAPI02_No12");
        $image = file_get_contents('/mnt/c/test1/tests/Feature/photo.jpg');

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        
        $response = Http::attach(
            'attachment', $image, 'photo.jpg'
        )->post('http://127.0.0.1/api/logout');

        $body_code = $response->json();
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);


        //print_r($image);
        //print_r($response);
    }
     
    public function testLogout02_No13()
    {
        Log::debug("LogoutAPI02_No13");

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );


        $response->assertStatus(200);
        //$this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = Http::asForm()->post('http://127.0.0.1/api/logout', [
        ]);
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);

        //print_r($response);
        //$response->dump();     
    }

    public function testLogout03_No1()
    {
        Log::debug("LogoutAPI03_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout03_No2()
    {
        Log::debug("LogoutAPI03_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        //$token = $response['access_token'];
        $token = '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout03_No3()
    {
        Log::debug("LogoutAPI03_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        //$token = $response['access_token'];
        $token = '39f21f4c498211ec48219b168d02a6db5a9e689d60a854sadw95dwadsadwawdd1';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout04_No1()
    {
        Log::debug("LogoutAPI04_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout04_No2()
    {
        Log::debug("LogoutAPI04_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',               
               'device_id' => 'test1',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',               
               'device_id' => 'test1',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

        public function testLogout04_No4()
    {
        Log::debug("LogoutAPI04_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);
        $token = $response['access_token'];

        $response = $this->withHeaders([
        ])->json('POST', '/api/createroom?Authorization=Bearer '.$token, []);
        $response->assertStatus(500);
    }

    public function testLogout04_No6()
    {
        Log::debug("LogoutAPI04_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/logout2', []);
         $response->assertStatus(404);

        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

    public function testLogout04_No7()
    {
        Log::debug("LogoutAPI04_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', '/api/logout', []);

         $response->assertStatus(405);


        //$response->dumpHeaders();
        //$response->dump();
        //print_r($response); 
    }

}
