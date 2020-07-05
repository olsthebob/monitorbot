<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Test;

class TestController extends Controller
{
    public function store(Request $request){

        // if element id is 
        $type = request('test_type');

        if($type == 'element'){
            $element_type = request('element_type');
            $element = $element_type . request('element');
        }
        $site_id = request('site_id');

        Test::create([
            'id' => Str::uuid(),
            'site_id' => $site_id,
            'organisation_id' => auth()->user()->organisation->id,
            'test_url' => request('test_url'),
            'type' => request('test_type'),
			'element' => $element ? $element : null
        ]);

        // Return Response
        session()->flash('status', "Your test was saved!");
        return response([
            'status' => 'success',
            'redirect' => route('show_site', $site_id)
        ]);
    }

}
