<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;
use App\Site;
use App\Test;

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

			// get all tests.
			$tests = Test::all();

			// loop through tests
			foreach( $tests as $test ):

				// save url and target site html as an object for comparison
				$url = $test->test_url;
				$html = HtmlDomParser::file_get_html( $url, 0, null, 0 );

				// for each different type of test, compare the code against specific conditions...
				if($test->type === "Check Google Analytics"){
					$comparison = !empty(strpos($html, '//www.googletagmanager.com/gtag/js?id='));
				}
				elseif($test->type === "Check Tag Manager") {
					$comparison = !empty(strpos($html, '//www.googletagmanager.com/gtag/js?id='));
				}
				elseif($test->type === "Check Meta Description") {
					foreach($html->find("meta[name='description']") as $element){
						$content = $element->content;
					}
					$comparison = (isset($content) && !empty($content)) ? 1 : 0;
				}
				elseif($test->type === "Check Element Loading") {
					$element = $test->element;
					$comparison = $html->find($element);
				}

				// store results of test into variable.
				$result = $comparison ? 1 : 0;

				// update test record to reflect result.
				Test::updateOrCreate(
					['id' => $test->id],
					['status' => $result]
				);

			endforeach;

		}
}
