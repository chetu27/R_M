<?php

namespace App\Http\Controllers\recipeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class AppController extends Controller
{
	public function index(Request $request){
    // dd($request->baarCodeNumber);


        if(!empty($request->baarCodeNumber)){
            $product_id = array_filter($request->baarCodeNumber);        
            $pi = implode(',', $product_id);
            $client = new Client(); //GuzzleHttp\Client
            $url = "http://localhost/chetu/fbag1/wp-json/custom-api/getProductById?pid=".$pi;
            $response = $client->request('GET', $url);
            $responseBody = json_decode($response->getBody(),true);
            // dd($responseBody);
            return view('recipe_app.recipe_app', compact('responseBody'));
            
        }else{
            return view('recipe_app.recipe_app');     
        }

	}

    public function searchProduct(Request $request){
        if($request->get('query'))
            {
                $query = $request->get('query');
                $client = new Client(); //GuzzleHttp\Client
                $url = "http://localhost/chetu/fbag1/wp-json/custom-api/searchAutoComplete?pro_name=".$query;
                $response = $client->request('GET', $url);
                $data = json_decode($response->getBody());
                $output = '<ul class="dropdown-menu" style="display:block;">';
                foreach($data as $row)
                    {
                        $output .= '<li><a href="#">'.$row->product_name.'</a></li>';
                    }
                $output .= '</ul>';
                echo $output;
            }
    }
    public function productValid(Request $request){
        //dd($request->all());
        if(!empty($request->findProductName)){
            $fProName = $request->findProductName;
            // dd($fProName);
            $client = new Client(); //GuzzleHttp\Client
            $url = "http://localhost/chetu/fbag1/wp-json/custom-api/productAvailable?checkPro=".$fProName;
            $response = $client->request('GET', $url);
            $responseBody = json_decode($response->getBody());
            // dd($responseBody);
            return $responseBody;
        }
    }
}