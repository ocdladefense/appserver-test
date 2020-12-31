<?php 

class TestModule extends Module {

    public function __construct() {
        parent::__construct();
    }

		
		
		public function userProfile() {

			$title = "<h2>My profile</h2>";
			$content = "<a href='/user/logout'>Logout of OCDLA App</a><p>&nbsp;</p>";
			
			// This session will be a SimpleSAML session.
			return $title."<pre>" . print_r($_SESSION, true) . "</pre>";
		}


		public function userSettings() {
		
			return "<h2>OCDLA App Settings</h2>";
		}
		
		
		public function userDocuments() {
		
			$docs = array(
				"dnb" => array(
					"id" => "dnb",
					"title" => "DUII Notebook",
					"chapters" => 18,
					"published" => "Jan. 1, 2020"
				),


				"fsm" => array(
					"id" => "fsm",
					"title" => "Felony Sentencing in Oregon",
					"chapters" => 10,
					"published" => "Jan. 1, 2020"
				),
				
				"im" => array(
					"id" => "im",
					"title" => "Investigators Manual",
					"chapters" => 18,
					"published" => "Jan. 1, 2020"
				),
				
				"ss" => array(
					"id" => "ss",
					"title" => "Search & Seizure",
					"chapters" => 10,
					"published" => "Jan. 1, 2020"
				),
				
				"vet" => array(
					"id" => "vet",
					"title" => "Veterans Manual",
					"chapters" => 15,
					"published" => "Jan. 1, 2020"
				),
				
				"sex-crimes" => array(
					"id" => "sex-crimes",
					"title" => "Defending Sex Cases",
					"chapters" => 19,
					"published" => "Jan. 1, 2020"
				),
				
				"mh" => array(
					"id" => "mh",
					"title" => "Mental Health Manual",
					"chapters" => 8,
					"published" => "Jan. 1, 2020"
				),
				
				"post-judgement" => array(
					"id" => "post-judgement",
					"title" => "Post-Judgment Manual",
					"chapters" => 11,
					"published" => "Jan. 1, 2020"
				),
				
				"scientific-evidence" => array(
					"id" => "scientific-evidence",
					"title" => "Scientific Evidence",
					"chapters" => 7,
					"published" => "Jan. 1, 2020"
				),
				
				"trial-notebook" => array(
					"id" => "trial-notebook",
					"title" => "Trial Notebook",
					"chapters" => 18,
					"published" => "Jan. 1, 2020"
				)
			);
			
			

			
			$files = array_map(function($doc) {
				$id = "sex-crimes";
				$title = $doc["title"];
				$chapters = $doc["chapters"];
				$published = "Jan. 1, 2020";
				$url = "/content/images/document.svg";

				
				return "<div class='doc'><a href='/books-online/{$id}' title='{$title}'><img style='width: 30%;' src='{$url}' /></a><div class='doc-info'><span class='doc-title'>{$title}</span><span class='doc-chapters'>{$chapters} chapters</span><span class='doc-published'>{$published}</span>    </div></div>";
			}, $docs);
			
			return join("\n",$files);
		}


		public function loadChapter1($bonId) {
		
		
		
		
			return file_get_contents("/var/www/webapp/appserver/content/modules/bon/sample.html");
		}

	

		public function login() {

			
				$as = new \SimpleSAML\Auth\Simple('default-sp');

				$as->requireAuth();

				$attributes = $as->getAttributes();
				// print_r($attributes);
			
				// This session will be a SimpleSAML session.
				// print_r($_SESSION);
			
				// This session will be a PHP session.
				// cleanup the SimpleSAML session; also restores the previous session.
				$session = \SimpleSAML\Session::getSessionFromRequest();
				$session->cleanup();
			
				User::add_session_data($attributes);
				
				header("Location: /home");
				exit;
		}
		


		
    public function testFunctionOne() {
		
        $list = XList::getDirContents(path_to_modules());
        
        print "<pre>".print_r($list,true) ."</pre>";
        exit;
        
        
        return "Hello from the first test function in the module.php file of the test module";
    }



    public function testFunctionTwo($testParam) {
        $testParam = "Hello from the second test function in the module.php file of the test module";
        
        
        return $testParam;
    }



    public function testFunctionThree() {
        throw new Exception("Error generated from the Test module.");
    }
}
