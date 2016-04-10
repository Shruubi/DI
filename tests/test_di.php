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

class Person {

	private $name;

	private $age;

	/**
	 * Person constructor.
	 *
	 * @param $name
	 * @param $age
	 */
	public function __construct($name, $age) {
		$this->name = $name;
		$this->age = $age;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getAge() {
		return $this->age;
	}
}

class Greeter {
	private $person;

	/**
	 * Greeter constructor.
	 *
	 * @param $person
	 */
	public function __construct($person) {
		$this->person = $person;
	}

	public function greet() {
		$name = $this->person->getName();
		$age = $this->person->getAge();
		return "Hello $name, you are $age years old!";
	}
}