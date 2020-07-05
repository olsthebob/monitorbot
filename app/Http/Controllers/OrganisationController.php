<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Organisation;
use App\User;

class OrganisationController extends Controller
{

    public function new() {
        
        // grab auth user object
        $user = auth()->user();

        // return view
        return view('organisations.new', compact('user'));
    }

    public function store(Request $request) {

        // validate name of organisation as input
        $this->validate(request(),[
             'name' => 'required',
        ]);

        // create a new organisation
        $organisation = Organisation::create([
            'id' => Str::uuid(),
            'name' => request('name'),
        ]);

        // update current user record to include reference to organisation.
        User::updateOrCreate(
            ['id' => auth()->user()->id],
            ['organisation_id' => $organisation->id]
        );

        // redirect user to dashboard
        return redirect()->action(
            'DashboardController@index'
        );
    }

}
