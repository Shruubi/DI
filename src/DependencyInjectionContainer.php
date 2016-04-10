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

namespace Shruubi\DI;

use ReflectionClass;

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
     * @param array $params
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
                if ($param['type'] === 'ref') {
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
            if ($param[0] === '@') {
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