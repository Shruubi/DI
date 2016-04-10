<?php

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