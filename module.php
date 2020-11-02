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
