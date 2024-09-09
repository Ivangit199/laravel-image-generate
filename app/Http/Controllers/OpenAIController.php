<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Url;

class OpenAIController extends Controller 

{
    public function generateImage(Request $request) 
    {

        $description = isset($request->description)? $request->description : 'Sample Image';//get image description from view

        try {
            //get account of OpenAi
            $client = new Client([
                'base_uri' => 'https://api.openai.com/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openai.key'),
                    'Content-Type' => 'application/json',
                ],
            ]);
            //request from OpenAi
            $response = $client->post('images/generations', [
                'json' => [
                    "model" => "dall-e-3",//OpenAi model
                    "prompt" => $description,
                    "n" => 1,
                    "size" => "1024x1024"//image resolution
                ],
            ]);
    
            $result = json_decode($response->getBody()->getContents());//get result as string
            $url = $result->data[0]->url;
    
            //save url to url table
            Url::create([
                'url' => $url,
                'description' => $description
            ]);
       
    
            return response()->json(['status' => true, 'url' => $url]);//return to view with url

        } catch(\Exception $e) {
            return response()->json(['status' => false, 'url' => '']);
        }
      
    }
}

