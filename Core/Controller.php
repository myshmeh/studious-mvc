<?php

namespace Core;

abstract class Controller{
  protected $route_params = [];

  public function __construct($route_params){
    $this->route_params = $route_params;
  }

  //called when method calling is not found
  //'_action' is a common suffix to identify action method to run
  public function __call($name, $args){
    $method = $name. '_action';

    if(method_exists($this, $method)){
      if($this->before() !== false){
        call_user_func_array([$this, $method], $args);
        $this->after();
      }
    }
    else{
      //echo "Controller::__call>> Method $method not found in controller ". get_class($this);
      throw new \Exception("Method $method not found in controller". get_class($this));
    }
  }

  protected function before(){

  }

  protected function after(){

  }
}

 ?>
