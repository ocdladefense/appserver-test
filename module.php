<?php 

class TestModuleModule extends Module{
    private $deps = array("salesforce");

    public function __construct(){
        parent::__construct();
        $this->routes = $this->testModuleModRoutes();
        $this->dependencies = $this->deps;
        $this->name = "testModule";
        $this->files = array("TestClass.php");
    }

    private function testModuleModRoutes(){
        $testModuleModRoutes = array(
            "test-one-text" => array(
                "callback" => "testFunctionOne",
                "content-type" => "text/html"
            ),
            "test-one-json" => array(
                "callback" => "testFunctionOne",
                "content-type" => "application/json"
            ),
            "test-two-text" => array(
                "callback" => "testFunctionTwo",
                "content-type" => "text/html"
            ),
            "test-two-json" => array(
                "callback" => "testFunctionTwo",
                "content-type" => "application/json"
            ),
            "test-three-text" => array(
                "callback" => "testFunctionThree",
                "content-type" => "text/html"
            ),
            "test-three-json" => array(
                "callback" => "testFunctionThree",
                "content-type" => "application/json"
            )
        );
        return $testModuleModRoutes;
    }

    public function testFunctionOne(){
        return "Hello from the first test function in the module.php file of the test module";
    }

    public function testFunctionTwo($testParam){
        $testParam = "Hello from the second test function in the module.php file of the test module";
        return $testParam;
    }

    public function testFunctionThree(){
        $tc = New TestClass();
        return $tc->testMethodOne();
    }
}
