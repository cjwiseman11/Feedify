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


 /**
 *
 * @get the controller
 *
 * @access private
 *
 * @return void
 *
 */
private function getController() {

        /*** get the route from the url ***/
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

        if (empty($route))
        {
                $route = 'index';
        }
        else
        {
                /*** get the parts of the route ***/
                $parts = explode('/', $route);
                $this->controller = $parts[0];
                if(isset( $parts[1]))
                {
                        $this->action = $parts[1];
                }
        }

        if (empty($this->controller))
        {
                $this->controller = 'index';
        }

        /*** Get action ***/
        if (empty($this->action))
        {
                $this->action = 'index';
        }

        /*** set the file path ***/
        $this->file = $this->path .'/'. $this->controller . '.php';
  }
}
?>


