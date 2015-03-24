<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GrabberController extends Controller {

	public function showGrabber(){
    	$data = array();
        $keyword = Request::input('keyword');
        $data_img = $this->grabbing($keyword);
		if(isset($data_img) && count($data_img)>0){
			$i = 0;
			//foreach($data_img['responseData']['results'] as $data_img_single){
			foreach($data_img as $data_img_single){	
				foreach($data_img_single as $data_img_key => $data_img_value){
					$data[$i][$data_img_key] = $data_img_value;
				}
				$i++;
			}
		}	
        return view('admin.index', compact('data') );
    }

    public function grabImages(){
    	$urls = Request::input('included-image');
    	$title = Request::input('title');
    	$description = Request::input('description');
    	foreach($urls as $key => $url){
    		$filename = explode('/', $url);
    		$filename = end($filename);
    		
    		$data_img[] = array(
    				'url' => $urls[$key],
    				'title' => $title[$key],
    				'description' => $description[$key],
    				'filename' => $filename
    			);
    	}
        $categories = Category::all();
        foreach($categories as $category){
            $categorylist[$category->id] = $category->name;
        }
    	return view('admin.images', compact('data_img', 'categorylist'));
    }

    private function grabbing($q){
    	$q = urlencode($q);
		$start = (isset($_REQUEST['p']))?urlencode($_REQUEST['p']):0;
		//$json_img = file_get_contents("https://www.google.com/uds/GimageSearch?rsz=8&q=".$q."&v=1.0&start=".$start."&imgsz=large");
        $json_img = file_get_contents('https://ajax.googleapis.com/ajax/services/search/images?'.'rsz=8&q='.$q.'&v=1.0&start='.$start.'&imgsz=large');
        $data_img_json = json_decode($json_img,true);
        $pages = array_get($data_img_json, 'responseData.cursor.pages');
        
        $data_img_json = array_get($data_img_json, 'responseData.results');
        $data_img = array_merge_recursive($data_img_json);

        
        $pagelimit = 4; //max 7
        for($i = 1; $i < $pagelimit; $i++){
            $start = $pages[$i]['start'];
            $json_img = file_get_contents('https://ajax.googleapis.com/ajax/services/search/images?'.'rsz=8&q='.$q.'&v=1.0&start='.$start.'&imgsz=large');
            $data_img_json = json_decode($json_img,true);
            $data_img_json = array_get($data_img_json, 'responseData.results');
            $data_img = array_merge_recursive($data_img, $data_img_json);
        }

		return $data_img;
	}    
}
