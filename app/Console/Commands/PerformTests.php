<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;
use App\Site;

class PerformTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iterate over each site and perform key tests as instructed by the user.';

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

				$tests = $site->tests;

				foreach( $tests as $test ):

					$type = "detect_element";
					$url = "http://ollybradshaw.com";
					$object = "h2";

					echo $object;
					die();

					if($type === 'detect_element'){
						$html = HtmlDomParser::file_get_html( $url, false, null, 0 );
						echo $html;
						$el = $html->find($object);

						if($el){
							$i=0;
							foreach( $el as $element){
								$i++;
							}
							echo "PASS: found " . $i . " elements that match. \n";
						} else {
							echo "FAIL: no elements found. \n";
						}
					}

					if($type === 'check_analytics'){
						$html = HtmlDomParser::file_get_html( $url, false, null, 0 );
						//echo $html;

						if (strpos($html, '//www.google-analytics.com/analytics.js') !== false) {
							echo "PASS: found analytics code\n";
						} else {
							echo "FAIL: no analytics code found. \n";
						}
					}

					if($type === 'check_tag_manager'){
						$html = HtmlDomParser::file_get_html( $url, false, null, 0 );
						//echo $html;

						if (strpos($html, 'https://www.googletagmanager.com/gtm.js?id=') !== false) {
							echo "PASS: found tag manager code\n";
						} else {
							echo "FAIL: no tag manager code found. \n";
						}
					}

				endforeach;

			endforeach;

		}
}
