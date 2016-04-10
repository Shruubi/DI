<?php

//require test classes
require_once "test_di.php";

use Shruubi\DI\DependencyInjectionContainer;

class TestDIContainer extends PHPUnit_Framework_TestCase {
    protected function setUp() {
        DependencyInjectionContainer::instantiate('di_definitions.json');
    }

    public function testFetchObject() {
        /** @var Greeter $greeter */
        $greeter = DependencyInjectionContainer::getInstance()->resolve('greeter');
        self::assertEquals("Hello Damon, you are 23 years old!", $greeter->greet());
    }
}
