<?php

/*
 * Main implementation of the DI container.
 * Copyright (C) 2016  Damon Swayn <me@shruubi.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

//require test classes
require_once "test_di.php";

use Shruubi\DI\DependencyInjectionContainer;

class DIContainerTest extends PHPUnit_Framework_TestCase {
    protected function setUp() {
        DependencyInjectionContainer::instantiate(__DIR__ . '/di_definitions.json');
    }

    public function testFetchObject() {
        /** @var Greeter $greeter */
        $greeter = DependencyInjectionContainer::getInstance()->resolve('greeter');
        self::assertEquals("Hello Damon, you are 23 years old!", $greeter->greet());
    }

    public function testAutoloadedClassInjection() {
        $autoloaded = DependencyInjectionContainer::getInstance()->resolve('testAutoload');
        self::assertEquals(42, $autoloaded->getANumber());
    }
}
