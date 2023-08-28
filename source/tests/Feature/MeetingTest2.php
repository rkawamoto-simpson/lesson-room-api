<?php

namespace Tests\Feature;

use App\Models\OnlineMeetingInfo;
use App\Models\SessionLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MeetingTest2 extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStartMeeting01_No1()
    {
        Log::debug("StartMeetingAPI01_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        /*
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        $response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);   */     

    }

    public function testStartMeeting01_No2()
    {
        Log::debug("StartMeetingAPI01_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    public function testStartMeeting01_No3()
    {
        Log::debug("StartMeetingAPI01_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]); 
    }

    public function testStartMeeting01_No4()
    {
        Log::debug("StartMeetingAPI01_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
    }

    public function testStartMeeting01_No5()
    {
        Log::debug("StartMeetingAPI01_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testStartMeeting01_No6()
    {
        Log::debug("StartMeetingAPI01_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");     
    }

    public function testStartMeeting01_No7()
    {
        Log::debug("StartMeetingAPI01_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test33',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");      
    }

    public function testStartMeeting01_No8()
    {
        Log::debug("StartMeetingAPI01_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtesttt',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200); 
        $this->assertEquals($response['result'], "-1");      
    }

    public function testStartMeeting01_No9()
    {
        Log::debug("StartMeetingAPI01_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(200);     

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $room_id= 'testdate';
        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);

    }

    public function testStartMeeting01_No10()
    {
        Log::debug("StartMeetingAPI01_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;
        print_r($room_id);
        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
    }

    public function testStartMeeting02_No1()
    {
        Log::debug("StartMeetingAPI02_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);



        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);
        $response->dump();            
    }

    public function testStartMeeting02_No2()
    {
        Log::debug("StartMeetingAPI02_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting2', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        
        $response->assertStatus(404);
        $response->dump();
    }

    public function testStartMeeting02_No3()
    {
        Log::debug("StartMeetingAPI02_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
       
        $response->assertStatus(200);
        $response->dump();
    }

    public function testStartMeeting02_No4()
    {
        Log::debug("StartMeetingAPI02_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('GET', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(405);      
    }

    public function testStartMeeting02_No5()
    {
        Log::debug("StartMeetingAPI02_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting?room_id=$room_id&callback_url=http://www.saver.jp&device_id=$user_name', [
        ]);

        //$response->dumpHeaders();
        
        $response->assertStatus(400);
        $response->dump();
    }

    public function testStartMeeting02_No6()
    {
        Log::debug("StartMeetingAPI02_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting02_No7()
    {
        Log::debug("StartMeetingAPI02_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
        ]);

        //$response->dumpHeaders();

        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
        $response->dump();
    }

    public function testStartMeeting02_No8()
    {
        Log::debug("StartMeetingAPI02_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $image = file_get_contents('/mnt/c/test1/tests/Feature/photo.jpg');
        $response = Http::attach(
            'attachment', $image, 'photo.jpg'
        )->post('http://127.0.0.1/api/startmeeting');

        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 422);    
    }
    
    public function testStartMeeting02_No9()
    {
        Log::debug("StartMeetingAPI02_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = Http::asForm()->post('http://127.0.0.1/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);
        //$response->dumpHeaders();
        //$response->dump();     
    }

    public function testStartMeeting03_No1()
    {
        Log::debug("StartMeetingAPI03_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '1',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No2()
    {
        Log::debug("StartMeetingAPI03_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '漢字',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No3()
    {
        Log::debug("StartMeetingAPI03_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '!!!!',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No4()
    {
        Log::debug("StartMeetingAPI03_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];
        /*
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
            */
        $faker = $this->faker;
        
        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No5()
    {
        Log::debug("StartMeetingAPI03_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testStartMeeting03_No6()
    {
        Log::debug("StartMeetingAPI03_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => 'root',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No7()
    {
        Log::debug("StartMeetingAPI03_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => 'admin',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No8()
    {
        Log::debug("StartMeetingAPI03_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => 'Adminstrator',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No9()
    {
        Log::debug("StartMeetingAPI03_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '実験',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No10()
    {
        Log::debug("StartMeetingAPI03_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => '!#$%&()',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No11()
    {
        Log::debug("StartMeetingAPI03_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               //'room_id' => $room_id,
               'room_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqa',
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }

    public function testStartMeeting03_No12()
    {
        Log::debug("StartMeetingAPI03_No12");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No13()
    {
        Log::debug("StartMeetingAPI03_No13");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp/1105',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No14()
    {
        Log::debug("StartMeetingAPI03_No14");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        //$response->dump();
        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp/漢字',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No15()
    {
        Log::debug("StartMeetingAPI03_No15");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        //$response->dump();
        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp/!%!%',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No16()
    {
        Log::debug("StartMeetingAPI03_No16");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        //$response->dump();
        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No17()
    {
        Log::debug("StartMeetingAPI03_No17");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => '',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }


    public function testStartMeeting03_No18()
    {
        Log::debug("StartMeetingAPI03_No18");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        //$response->dump();
        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqa',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testStartMeeting03_No19()
    {
        Log::debug("StartMeetingAPI03_No19");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => '1',
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No20()
    {
        Log::debug("StartMeetingAPI03_No19");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => '漢字',
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No21()
    {
        Log::debug("StartMeetingAPI03_No21");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => '!"#$%',
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No22()
    {
        Log::debug("StartMeetingAPI03_No22");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);      
    }

    public function testStartMeeting03_No23()
    {
        Log::debug("StartMeetingAPI03_No21");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => '',
        ]);

        print_r("device_idが空の時");
        //$response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testStartMeeting03_No24()
    {
        Log::debug("StartMeetingAPI03_No24");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        //$user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqa',
        ]);

        print_r("device_idが256文字の時");
        //$response->dumpHeaders();
       
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
        $response->dump();
    }

    public function testStartMeeting04_No1()
    {
        Log::debug("StartMeetingAPI04_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
    }

    public function testStartMeeting04_No2()
    {
        Log::debug("StartMeetingAPI04_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        ); 
    }

    public function testStartMeeting04_No3()
    {
        Log::debug("StartMeetingAPI04_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting?room_id=$room_id&callback_url=http://www.saver.jp&device_id=$user_name', [
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(400);      
    }



    public function testStartMeeting04_No6()
    {
        Log::debug("StartMeetingAPI04_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting2', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(404);      
    }

    public function testStartMeeting04_No7()
    {
        Log::debug("StartMeetingAPI04_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('GET', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(405);      
    }

    public function testStartMeeting04_No8()
    {
        Log::debug("StartMeetingAPI04_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }



    public function testEndMeeting01_No1()
    {
        print_r("ここからEndMeeting開始");
        Log::debug("EndMeetingAPI01_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );
    }

    public function testEndMeeting01_No2()
    {
        Log::debug("EndMeetingAPI01_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting01_No3()
    {
        Log::debug("EndMeetingAPI01_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting01_No4()
    {
        Log::debug("EndMeetingAPI01_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting01_No5()
    {
        Log::debug("EndMeetingAPI01_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200); 
        $this->assertEquals($response['result'], "-1");

        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");     
     
    }

    public function testEndMeeting01_No6()
    {
        Log::debug("EndMeetingAPI01_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");        
    }

    public function testEndMeeting01_No7()
    {
        Log::debug("EndMeetingAPI01_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test33',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200); 
        $this->assertEquals($response['result'], "-1");

        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testEndMeeting01_No8()
    {
        Log::debug("EndMeetingAPI01_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtesttt',
            ]
        );

        //print_r($response); 
        //$response->assertStatus(500);
        $this->assertEquals($response['result'], "-1");

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);      

        $faker = $this->faker;

        
        //$room_id = $response['room_id'];
        $room_id ='';       
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200); 
        $this->assertEquals($response['result'], "-1");


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testEndMeeting01_No9()
    {
        Log::debug("EndMeetingAPI01_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        //$room_id = $response['room_id'];
        $room_id = 'testdate';
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);       
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting01_No10()
    {
        Log::debug("EndMeetingAPI01_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];

        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();
        $room_id = 'testdate';
        $response->assertStatus(200);       
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting02_No1()
    {
        Log::debug("EndMeetingAPI02_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        $response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting02_No2()
    {
        Log::debug("EndMeetingAPI02_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting2', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(404);
    }

    public function testEndMeeting02_No3()
    {
        Log::debug("EndMeetingAPI02_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(200);
    }

    public function testEndMeeting02_No4()
    {
        Log::debug("EndMeetingAPI02_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('GET', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(405);
    }

    public function testEndMeeting02_No5()
    {
        Log::debug("EndMeetingAPI02_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting?room_id=$room_id&device_id=$user_name', [
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting02_No6()
    {
        Log::debug("EndMeetingAPI02_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(200);
    }

    public function testEndMeeting02_No7()
    {
        Log::debug("EndMeetingAPI02_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testEndMeeting02_No8()
    {
        Log::debug("EndMeetingAPI02_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $image = file_get_contents('/mnt/c/test1/tests/Feature/photo.jpg');
        $response = Http::attach(
            'attachment', $image, 'photo.jpg'
        )->post('http://127.0.0.1/api/endmeeting');        

        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);

        //$response->dumpHeaders();
        //$response->dump();
    }


    public function testEndMeeting02_No9()
    {
        Log::debug("EndMeetingAPI02_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = Http::asForm()->post('http://127.0.0.1/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);

        //$response->dumpHeaders();
        //$response->dump();
    }

    public function testEndMeeting03_No1()
    {
        Log::debug("EndMeetingAPI03_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '1',
               'device_id' => '1',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No2()
    {
        Log::debug("EndMeetingAPI03_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '漢字',
               'device_id' => '漢字',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No3()
    {
        Log::debug("EndMeetingAPI03_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '!!!!',
               'device_id' => '!!!!',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No4()
    {
        Log::debug("EndMeetingAPI03_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
               'device_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No5()
    {
        Log::debug("EndMeetingAPI03_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }

    public function testEndMeeting03_No6()
    {
        Log::debug("EndMeetingAPI03_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'root',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No7()
    {
        Log::debug("EndMeetingAPI03_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'admin',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No8()
    {
        Log::debug("EndMeetingAPI03_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'Adminstrator',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No9()
    {
        Log::debug("EndMeetingAPI03_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '異常',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No10()
    {
        Log::debug("EndMeetingAPI03_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '!#$!#$',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No11()
    {
        Log::debug("EndMeetingAPI03_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqa',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No12()
    {
        Log::debug("EndMeetingAPI03_No12");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '1',
               'device_id' => '1',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No13()
    {
        Log::debug("EndMeetingAPI03_No13");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' =>'漢字',
               'device_id' => '漢字',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No14()
    {
        Log::debug("EndMeetingAPI03_No14");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => '!!!!',
               'device_id' => '!!!!',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No15()
    {
        Log::debug("EndMeetingAPI03_No15");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
               'device_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqq',
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }

    public function testEndMeeting03_No16()
    {
        Log::debug("EndMeetingAPI03_No16");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => '',
        ]);

        //$response->dumpHeaders();
        $response->dump();

        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");        
    }

    public function testEndMeeting03_No17()
    {
        Log::debug("EndMeetingAPI03_No17");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => 'wqqqqqqqqqqqqqqqqqqqqqwqqqqqqqqqqqqqqqqqqqqqqwesawdasawdsaaaaaaaaaaaaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqqqqqqqqqqqqqqqqqqqqqqqqqdddddddddddddddddddddddddddddddddssssssssssssssssssssssssssssaaaaaaaaaaaaaawwwwwwwwwwwwwwwwwwwwwwwwwwwwwqqqqqa',
        ]);
        //$response->dumpHeaders();
        $response->dump();
        $response->assertStatus(400);
    }

    public function testEndMeeting04_No1()
    {
        Log::debug("EndMeetingAPI04_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        $response->dumpHeaders();
        $response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting04_No2()
    {
        Log::debug("EndMeetingAPI04_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        );  
    }

    public function testEndMeeting04_No3()
    {
        Log::debug("EndMeetingAPI04_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);
        $response->assertStatus(200);
        //$response->dumpHeaders();
        //$response->dump();


        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting', [
               'room_id' => 'Adminstrator',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(400);
    }



    public function testEndMeeting04_No6()
    {
        Log::debug("EndMeetingAPI04_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/endmeeting2', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(404);
    }

    public function testEndMeeting04_No7()
    {
        Log::debug("EndMeetingAPI04_No7");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
        
        $response = $this->withHeaders([
        ])->json('GET', '/api/endmeeting', [
               'room_id' => $room_id,
               'device_id' => $user_name,
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(405);
    }

    public function testEndMeeting04_No8()
    {
        Log::debug("EndMeetingAPI04_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        $faker = $this->faker;

        $room_id = $response['room_id'];
        $user_name = $faker->userName;

        $response = $this->withHeaders([
        ])->json('POST', '/api/startmeeting', [
               'room_id' => $room_id,
               'callback_url' => 'http://www.saver.jp',
               'device_id' => $user_name,
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
        ]);

        //$response->dumpHeaders();
        //$response->dump();

        $response->assertStatus(200);
        $this->assertEquals($response['result'], "-1");
    }
}
