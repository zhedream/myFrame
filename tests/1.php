<?php

class Person {

    public $name;

    /**
     * get name of person
     */
    public function getName() {
        return $this->name;
    }

    public function setName($v) {
        $this->name = $v;
    }
}

$rm = new ReflectionMethod('Person', 'getName');

// print_r($rm->isPublic());
print_r($rm->getDocComment());

