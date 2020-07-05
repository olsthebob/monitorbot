<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Site;
use App\Alert;

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
            if( !empty($site->production_url) ):

                $curl = curl_init($site->production_url);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_NOBODY, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl, CURLOPT_TIMEOUT,15);
                $output = curl_exec($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                $activeAlert = $site->alerts->where('resolved', '0')->first();

                // if an alert exists, just check for 200 response.
                if( $activeAlert ):

                    if( $httpcode == '200'):
                        $alert = Alert::updateOrCreate(
                            ['id' => $activeAlert->id],
                            [
                                'resolved' => true,
                                'resolved_at' => Carbon::now(),
                            ]
                        );
                        $users = $site->organisation->users;
                        foreach( $users as $user):
                            $user->notify(new AlertResolved($alert));
                        endforeach;
                    endif;

                // no alert exists - check for downtime..
                else:
                    if($httpcode == '200'):

						echo $site->production_url . " is up.";

                    elseif($httpcode == '0'):

						echo "Lookup failed for " . $site->production_url . " because service is down.";
                        Log::error($site->production_url . ' has a status code of 0. Further investigation needed');

                    else:

                        if($httpcode == '404'):
							echo $site->production_url . " could not be found.";
                            $status = 'Unavailable';
                            $message = 'Website returned 404 - Page not found.';
                        elseif($httpcode == '503'):
							echo $site->production_url . " is unavailable.";
                            $status = 'Unavailable';
                            $message = 'Website returned 503 - Service Unavailable';
                        elseif($httpcode == '500'):
							echo $site->production_url . " is returning a 500 server error.";
                            $status = 'Unavailable';
                            $message = 'Website returned 500 Internal Server Error';
                        elseif($httpcode == '302'):
							echo $site->production_url . " is redirecting to a different URL.";
                            $status = 'Redirecting';
                            $message = 'Website returned 302 (Temporary) Redirection. Please reconfigure your stored website URL';
                        elseif($httpcode == '301'):
							echo $site->production_url . " is redirecting to a different URL.";
                            $status = 'Redirecting';
                            $message = 'Website returned 301 (Permanent) Redirection. Please reconfigure your stored website URL';
                        endif;

                        $timestamp = date('YmdHis').substr(microtime(0), 2, 3);

                        $alert = Alert::create([
                            'id' => $timestamp,
                            'site_id' => $site->id,
                            'organisation_id' => $site->organisation->id,
                            'status' => $status,
                            'message' => $message,
                        ]);

                        $users = $site->organisation->users;
                        foreach( $users as $user):
                            $user->notify(new AlertCreated($alert));
                        endforeach;

                    endif;
                endif;

            endif;
        endforeach;

    }
}
