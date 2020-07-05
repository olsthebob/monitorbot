<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Site;
use App\User;

class SitesController extends Controller
{

    public function show(Site $site) {
        $tests = $site->tests;
        $alerts = $site->alerts->where('resolved', '0')->first();
        return view('sites.show', compact('site', 'alerts', 'tests'));
    }

    public function edit(Site $site) {
        return view('sites.edit', compact('site'));
    }

    public function store(Request $request){

        $this->validate(request(),[
            'name' => 'required',
        ]);

        Site::create([
            'id' => Str::uuid(),
            'name' => request('name'),
            'organisation_id' => auth()->user()->organisation->id,
            'site_url' => request('site_url'),
        ]);

        // Return Response
        session()->flash('status', "Your site was saved!");
        return response([
            'status' => 'success',
            'redirect' => route('dashboard')
        ]);

    }

    public function update(Request $request, $id) {

        $this->validate(request(),[
            // validations go here
            // 'field_name' => 'required',
        ]);

        Site::where('id', $id)->update($request->except(['_token']));

        return redirect()->action(
            'DashboardController@index'
        );

    }

}
