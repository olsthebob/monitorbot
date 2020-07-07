<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Site;
use App\Alert;

use Illuminate\Support\Str;

use App\Notifications\AlertCreated;
use App\Notifications\AlertResolved;

class MonitorWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check to see all websites HTTP codes every 5 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // get all sites.
        $sites = Site::all();

        // check all site urls with curl.
        foreach( $sites as $site ):

          // does the site have an open, unresolved alert?
          $openAlert = $site->alerts->where('resolved', '0')->first();

          // init curl
          $curl = curl_init($site->site_url);

          // set curl options
          $options = array(
            CURLOPT_HEADER => true, // pass headers into data stream
            CURLOPT_NOBODY => true, // get request without body
            CURLOPT_RETURNTRANSFER => 1, // return transfer as string of return value of exec()
            CURLOPT_TIMEOUT => 15 // set timeout
          );
          curl_setopt_array($curl, $options);

          // do the curl
          curl_exec($curl);

          // grab the http code and store
          $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

          // close curl
          curl_close($curl);

          // if there is an open alert
          if($openAlert){
            
            if($httpcode == '200'){
              $alert = Alert::updateOrCreate(
                ['id' => $openAlert->id],
                ['resolved' => true],
                ['resolved_at' => Carbon::now()]
              );
              foreach($site->organisation->users as $user):
                $user->notify(new AlertResolved($alert));
              endforeach;
            }
            
          }

          else {

            if($httpcode == '0'){
              Log::error(
                $site->site_url . ' has a status code of 0. Further investigation needed'
              );
            }

            elseif(in_array($httpcode, array('301', '302', '404', '500', '503'))){

              $alert = Alert::create([
                'id' => Str::uuid(),
                'site_id' => $site->id,
                'organisation_id' => $site->organisation->id,
                'status' => $httpcode,
                'message' => 'Website Returned ' . $httpcode . ' Error',
              ]);

              foreach($site->organisation->users as $user):
                $user->notify(new AlertCreated($alert));
              endforeach;

            }

            else {
              Log::error(
                $site->site_url . ' has a status code of ' . $httpcode . '. Further investigation needed'
              );
            }

          }
        endforeach;
    }
}
