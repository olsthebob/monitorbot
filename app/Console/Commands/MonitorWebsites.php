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

        // check all production urls with curl.
        foreach( $sites as $site ):

          // does the site have an open, unresolved alert?
          $openAlert = $site->alerts->where('resolved', '0')->first();

          // curl the site and collect httpcode.
          $curl = curl_init($site->site_url);
          $options = array(
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 15
          );
          curl_setopt_array($curl, $options);
          $output = curl_exec($curl);
          $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
          curl_close($curl);

          if($openAlert){
            if($httpcode == '200'){
              Alert::updateOrCreate(
                ['id' => $openAlert->id],
                ['resolved' => true],
                ['resolved_at' => Carbon::now()]
              );
            }
          }
          else {
            if($httpcode == '0'){
              Log::error($site->site_url . ' has a status code of 0. Further investigation needed');
            }
            elseif(in_array($httpcode, array('301', '302', '404', '500', '503'))){
              $alert = Alert::create([
                'id' => Str::uuid(),
                'site_id' => $site->id,
                'organisation_id' => $site->organisation->id,
                'status' => $httpcode,
                'message' => 'Website Returned ' . $httpcode . ' Error',
              ]);
            }
            else {
              Log::error($site->site_url . ' has a status code of ' . $httpcode . '. Further investigation needed');
            }
          }
          
        endforeach;
    }
}
