<?php

class Dependency {

	/**
	 * @var string
	 */
	private $class;

	/**
	 * @var array
	 */
	private $params;

	/**
	 * Dependency constructor.
	 *
	 * @param string $class
	 * @param array  $params
	 */
	public function __construct($class, array $params) {
		$this->class = $class;
		$this->params = $params;
	}

	/**
	 * @return string
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}
}

class DependencyInjectionContainer {

	/**
	 * @var DependencyInjectionContainer
	 */
	private static $_instance;

	/**
	 * @return DependencyInjectionContainer
	 */
	public static function getInstance() {
		return self::$_instance;
	}
	
	public static function instantiate($config) {
		$contents = file_get_contents($config);
		$json = json_decode($contents, true);
		$items = array();

		foreach ($json['objects'] as $obj) {
			$className = $obj['class'];
			$name = $obj['name'];
			$params = array();

			foreach ($obj['params'] as $param) {
				if($param['type'] === 'ref') {
					$params[] = '@' . $param['value'];
				} else {
					$params[] = $param['value'];
				}
			}

			$items[$name] = new Dependency($className, $params);
		}

		self::$_instance = new DependencyInjectionContainer($items);
	}

	/**
	 * @var array
	 */
	private $lookupTable;
	
	private function __construct($lookupTable) {
		$this->lookupTable = $lookupTable;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function resolve($name) {
		$dependency = $this->lookupTable[$name];
		$className = $dependency->getClass();
		$params = $dependency->getParams();

		$instantiationList = array();

		foreach ($params as $param) {
			if($param[0] === '@') {
				$refName = substr($param, 1);
				$instantiationList[] = $this->resolve($refName);
			} else {
				$instantiationList[] = $param;
			}
		}

		$reflectionClass = new ReflectionClass($className);
		return $reflectionClass->newInstanceArgs($instantiationList);
	}
}