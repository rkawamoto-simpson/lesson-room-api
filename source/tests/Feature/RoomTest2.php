<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RoomTest2 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateRoom01_No1()
    {
        Log::debug("RoomAPI01_No1");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = $response['access_token'];
        print_r($token);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        

        //$response->dumpHeaders();
        $response->dump();            
    }

    public function testCreateRoom01_No2()
    {
        Log::debug("RoomAPI01_No2");
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

        //$response->dumpHeaders();
        //$response->dump();            
    }
    
    public function testCreateRoom01_No3()
    {
        Log::debug("RoomAPI01_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        //$response->dump();
        $response2 = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response2->assertStatus(200);
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

        //$response->dumpHeaders();
        //$response->dump();            
    }
    
    public function testCreateRoom01_No4()
    {
        Log::debug("RoomAPI01_No4");
        $response = $this->post('/api/login',
           [
               'name' => '確認',
               'password' => '12345678@',
               'device_id' => 'test1',
            ]
        );
        //$response->dump();
        $response->assertJsonFragment([
            'result' => "0",
        ]);
        $response2 = $this->post('/api/login',
           [
               'name' => '確認',
               'password' => '12345678@',
               'device_id' => 'test1',
            ]
        );
        //print_r($response); 
        $response2->assertStatus(200);
        $this->assertEquals($response['result'], 0);
        //$response->dump();

        $token = $response['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]
        ); 
    }

    public function testCreateRoom01_No5()
    {
        Log::debug("RoomAPI01_No5");
        $response = $this->post('/api/login',
           [
               'name' => 'saver',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(400);
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom01_No6()
    {
        Log::debug("RoomAPI01_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => '!ststtesttest',
               'device_id' => 'test1',
            ]
        );

        //print_r($response); 
        $response->assertStatus(400);
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom01_No7()
    {
        Log::debug("RoomAPI01_No7");
        $response = $this->post('/api/login',
           [
               'name' => '<script>test3</script>',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(400);
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom01_No8()
    {
        Log::debug("RoomAPI01_No8");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => '<script>testtest</script>',
            ]
        );

        //print_r($response); 
        $response->assertStatus(400);
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom01_No9()
    {
        Log::debug("RoomAPI01_No9");
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
        $response->dump();      
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);

        //$response->dumpHeaders();
        $response->dump();            
    }

    public function testCreateRoom01_No10()
    {
        Log::debug("RoomAPI01_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        //$token = $response['access_token'];
        $token = 'testdate';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);
        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom01_No12()
    {
        Log::debug("RoomAPI01_No12");
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
        ])->json('POST', '/api/createroom', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);   
    }

    public function testCreateRoom02_No1()
    {
        Log::debug("RoomAPI02_No1");
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom02_No2()
    {
        Log::debug("RoomAPI02_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom2', []);

        $response->assertStatus(404);
        /*
        $response
            ->assertStatus(404)
            ->assertJson([
                'result' => "-1",
            ]);        
        */      

        //$response->dumpHeaders();
        $response->dump();            
    }

    public function testCreateRoom02_No3()
    {
        Log::debug("RoomAPI02_No3");
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom02_No4()
    {
        Log::debug("RoomAPI02_No4");
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
        ])->json('GET', '/api/createroom', []);

        $response->assertStatus(405);        

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom02_No9()
    {
        Log::debug("RoomAPI02_No9");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        //$this->assertEquals($response['result'], 0);
        $token = $response['access_token'];
        

        // $response = $this->post('/api/login?name=test3&password=testtest',
        $response = $this->withHeaders([
        ])->json('POST', '/api/createroom?Authorization=Bearer '.$token, []);

        $response->assertStatus(500);

        /*
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 0,
            ]);        
         */
        //$response->dumpHeaders();
        $response->dump();            
    }

    public function testCreateRoom02_No10()
    {
        Log::debug("RoomAPI02_No10");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1234',
           ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(200);
        /*
        $response
            ->assertStatus(500)
            ->assertJson([
                'result' => "-1",
            ]);        
        */
        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom02_No11()
    {
        Log::debug("RoomAPI02_No11");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
           ]
        );

        //print_r($response); 
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }
        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);
        /*
        $response
            ->assertStatus(500)
            ->assertJson([
                'result' => "-1",
            ]);        
        */
        //$response->dumpHeaders();
        $response->dump();            
    }

    public function testCreateRoom02_No12()
    {
        Log::debug("RoomAPI02_No12");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1234',
           ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }


        $image = file_get_contents('/mnt/c/test1/tests/Feature/photo.jpg');
        $response = Http::attach(
            'attachment', $image, 'photo.jpg'
        )->post('http://127.0.0.1/api/createroom');

        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom02_No13()
    {
        Log::debug("RoomAPI02_No13");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
               'device_id' => 'test1234',
           ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = Http::asForm()->post('http://127.0.0.1/api/createroom', [
        ]);
        $status_code = $response->status();
        //print_r($status_code);
        $this->assertEquals($status_code, 200);

        //$response->dumpHeaders();
        //$response->dump();            
    }

    
    public function testCreateRoom03_No1()
    {
        Log::debug("RoomAPI03_No1");
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

        $response->assertStatus(200);     

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom03_No2()
    {
        Log::debug("RoomAPI03_No2");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);       

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom03_No3()
    {
        Log::debug("RoomAPI03_No3");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]);

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        $token = '39f21f4c498211ec48219b168d02a6db5a9e689d60a854sadw95dwadsadwawdd1';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom04_No1()
    {
        Log::debug("RoomAPI04_No1");
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom04_No2()
    {
        Log::debug("RoomAPI04_No2");
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

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom04_No4()
    {
        Log::debug("RoomAPI04_No4");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
           ]
        );

        //print_r($response); 
        $response->assertStatus(200);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }
        
        
        $response = $this->withHeaders([
        ])->json('POST', '/api/createroom', []);

        $response->assertStatus(500);
        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom04_No6()
    {
        Log::debug("RoomAPI03_No6");
        $response = $this->post('/api/login',
           [
               'name' => 'test3',
               'password' => 'testtest',
            ]
        );

        //print_r($response); 
        $response->assertStatus(200);
        $this->assertEquals($response['result'], 0);

        if($response['result'] == 0){
            $token = $response['access_token'];
        }else{
            $token =''; 
        }

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', '/api/createroom2', []);

        $response->assertStatus(404);  

        //$response->dumpHeaders();
        //$response->dump();            
    }

    public function testCreateRoom04_No7()
    {
        Log::debug("RoomAPI03_No7");
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
        ])->json('GET', '/api/createroom', []);

        $response->assertStatus(405);     

        //$response->dumpHeaders();
        //$response->dump();            
    }



}
