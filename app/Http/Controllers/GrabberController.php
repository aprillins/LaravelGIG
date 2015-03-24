<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GrabberController extends Controller {

	public function index(){
		return view('grab');
	}

	public function grab(Request $request){
		$keyword = urlencode($request->input('keyword')); //Keyword or query string
		$start = 0;
		$jsonData = file_get_contents('https://ajax.googleapis.com/ajax/services/search/images?'.'rsz=8&q='.$keyword.'&v=1.0&start='.$start.'&imgsz=large');
		$googleResponse = json_decode($jsonData);
		$googleResponseResults = $googleResponse->responseData->results;
		return view('result', compact('googleResponseResults'));  
	}
  
}
