<?php

class Person {
  
    public $name;
    
    public function __construct($name)
    {
      $this->name = $name;
    }
    
    public function getName()
    {
      return $this->name;
    }
    
    public function setName($sdfa)
    {
      $this->name = $v;
    }
  }
    
  $p = new ReflectionParameter(array('Person', 'setName'), 0);
    
  print_r($p->getPosition()); //0
  print_r($p->getName()); //v