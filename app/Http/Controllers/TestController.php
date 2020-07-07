<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Test;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request){

        if(request('test_type') == 'Check Element Loading'){
            $element_type = request('element_type');
            $element = $element_type . request('element');
        }

        $root_url = request('site_root_url');
        $page_url = request('test_url');

        $site_id = request('site_id');

        Test::create([
            'id' => Str::uuid(),
            'site_id' => $site_id,
            'organisation_id' => auth()->user()->organisation->id,
            'test_url' => !empty($page_url) ? $root_url . $page_url : $root_url,
            'type' => request('test_type'),
			'element' => !empty($element) ? $element : null
        ]);

        // Return Response
        session()->flash('status', "Your test was saved!");
        return response([
            'status' => 'success',
            'redirect' => route('show_site', $site_id)
        ]);
    }

}
