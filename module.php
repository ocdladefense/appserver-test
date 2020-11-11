<?php 

class TestModule extends Module {

    public function __construct() {
        parent::__construct();
    }

		
    public function testFunctionOne() {
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
