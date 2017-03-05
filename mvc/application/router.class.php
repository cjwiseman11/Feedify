<?php

class router {
  /*
  * @the registry
  */
  private $registry;

  /*
  * @the controller path
  */
  private $path;

  private $args = array();

  public $file;

  public $controller;

  public $action;

  function __construct($registry) {
        $this->registry = $registry;
  }

  /**
  *
  * @set controller directory path
  *
  * @param string $path
  *
  * @return void
  *
  */
  function setPath($path) {
     /*** check if path i sa directory ***/
     if (is_dir($path) == false)
     {
             throw new Exception ('Invalid controller path: `' . $path . '`');
     }
     /*** set the path ***/
     $this->path = $path;
  }
}

?>
