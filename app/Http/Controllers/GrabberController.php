<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class GrabberController extends Controller {
    
    public function index(){
        return view('grab');
    }

	public function grab(Request $request){
		$keyword = urlencode($request->input('keyword')); // Keyword or query string
		$start = 0;
		$jsonData = file_get_contents('https://ajax.googleapis.com/ajax/services/search/images?'.'rsz=8&q='.$keyword.'&v=1.0&start='.$start.'&imgsz=large'); // Get raw data from Google
		$googleResponse = json_decode($jsonData);
		$googleResponseResults = $googleResponse->responseData->results; // Get result object from decoded $jsonData
		return view('result', compact('googleResponseResults')); // Passing $googleResponseResults variable to APPLICATION/resources/views/result.blade.php
	}
    public function saveImage($url){
        $url = urldecode($url); // Decode the encoded url from the route
        $image = Image::make($url); // Use intervention.io to make image from URL
        $pathinfo = pathinfo($url); 
        $filename = $pathinfo['filename']; // Get filename and its extension from URL
        $image->save(storage_path($filename)); // Save file to storage path of your laravel. In this case I use the default APPLICATION/storage path
        return redirect('/'); // Return to homepage
    }
}
