<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Alert;
use App\Site;
use App\User;
use App\Organisation;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get current user
        $user = auth()->user();

        // get current user organisation
        $organisation = $user->organisation->id;

        // get all sites belonging to user organisation
        $sites = Site::where('organisation_id', $organisation)->with('tests', 'alerts')->orderBy('name')->get();
        
        // return view
        return view('dashboard', compact('sites', 'user'));
    }
}
