<?php

use Http\Http as Http;
use File\FileList as FileList;
use File\File as File;
use Salesforce\SalesforceAttachment as SalesforceAttachment;
use Salesforce\OAuthRequest as OAuthRequest;
use Http\HttpRequest as HttpRequest;
use Salesforce\OAuthResponse as OAuthResponse;
use Salesforce\RestApiRequest as RestApiRequest;
use Http\HttpHeader as HttpHeader;

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
	

	// Connect to salesforce using a connected app
	public function connectToSalesforce(){

		$apiRequest = $this->loadForceApi();

		//$soql = "SELECT Id, FirstName, LastName FROM Contact WHERE FirstName = 'Trevor'";

		//$apiResponse = $apiRequest->query($soql);

		// $contact1 = array("FirstName" => "Trev1", "LastName" => "Ueh1");

		// $contact2 = array("FirstName" => "Trev2", "LastName" => "Ueh2");

		// $contact3 = array("FirstName" => "Trev3", "LastName" => "Ueh3");

		// $objects = array($contact1, $contact2, $contact3);

		//$apiResponse = $apiRequest->sendBatch($objects, "Contact");


		$product1 = array("Name" => "prod1");
		
		$objects = array($product1);
		
		$apiResponse = $apiRequest->sendBatch($objects, "Product2");

		var_dump($apiResponse); exit;
	}


	public function callTestAttachmentUpload(){

		$api = $this->loadForceApi("ocdla-sandbox");
		$parentId = "a1Kj0000000TordEAC";

		$req = $this->getRequest();

		//$fileName = "XXXXX_TEST_TEXT.txt";
		//$fileName = "XXXXX_TEST_PDF.pdf";
		$fileName = "XXXXX_TEST_PNG.png";
		$filePath = getPathToContent() . "/testFiles/{$fileName}";

		

		$list = new FileList();
		$list->addFile(File::fromPath($filePath));

		$file = new File("HelloWorld.txt");
		$file->setContent("Hello World");
		$list->addFile($file);
		
		$req->setFiles($list);

		$fileList = $req->getFiles();

		try{
			
			$resp = $api->uploadFiles($fileList, $parentId);

		} catch(Exception $e) {

			// Let the user know something went wrong.
		}


		var_dump($resp);

		exit;
	}

	public function testFileUploadForm(){

		return "<form method='post' action='/test/file/upload/form/callback' enctype='multipart/form-data'>
					<input type='file' name='jobUpload[]' multiple>
					<button id='submit' type='submit'>UPLOAD</button> 
				</form>";
	}

	public function testFileUploadFormCallback(){

		//$this->testUploadMultipleFilesAsAttachments();
		$this->testUploadOneFileAsAttachment();
		
	}

	public function testUploadOneFileAsAttachment(){

		// Create an interface that can return the object in a format that is compatable with the simple 0bject endpoint.
		$api = $this->loadForceApi("ocdla-sandbox");
		$parentId = "a1Kj0000000TordEAC"; // Two api requests

		$req = $this->getRequest();
		$fileList = $req->getFiles();

		$path = $fileList->getFirst()->getPath();

		$forceFile = new \SalesforceAttachment($path);
		$forceFile->setParentId($parentId);

		$resp = $api->uploadFile($forceFile);

		var_dump($resp);

		exit;
	}

	public function testUploadMultipleFilesAsAttachments(){

		$api = $this->loadForceApi("ocdla-sandbox");
		$parentId = "a1Kj0000000TordEAC";

		$req = $this->getRequest();
		$fileList = $req->getFiles();

		$resp = $api->uploadFiles($fileList, $parentId);

		var_dump($resp);

		exit;
	}

	public function testWebserverFlowAuthorizationStep(){  // Would this be called something like webserverLogin() ???????????????????????

		$config = getOauthConfig("ocdla-sandbox");

		$resp = OAuthResponse::newWebserverFlow($config);

		return $resp;
	}

	// Get the access token and save it to the session variables

	public function testWebserverFlowAccessTokenStep(){

		$config = getOauthConfig("ocdla-sandbox");  // Will be in the session or will be the config set as default.

		$code = $_GET["code"];

		$_SESSION["authorization_code"] = $code;  // Is it better to pass this in to from config as an optional parameter or store it in the session?

		// Begin loadForceApi flow.
		$oauth = OAuthRequest::fromConfig($config);

		$resp = $oauth->authorize();

		$body = json_decode($resp->getBody());

		// Is this in the OauthRequest class somewhere?
		if($body->error != null){

			throw new Exception("OAUTH_ERROR: {$body->error}, because of an {$body->error_description}.");
		}

		// Not too sure how important it is to save these to the session.
		$_SESSION["access_token"] = $body->access_token;
		$_SESSION["instance_url"] = $body->instance_url;

		$api = new RestApiRequest($body->instance_url, $body->access_token);
		// End loadForceApi flow.

		//$api = $this->loadForceApi("ocdla-sandbox");

		$result = $api->query("SELECT Id, Name FROM Job__c");

		$job = new stdClass();
		$job->Name = "Trevor's Test Job";

		$resp = $api->upsert("Job__c", $job);

		var_dump($resp);exit;

		return $resp;
	}
}
