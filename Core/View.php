<?php

  namespace Core;

  class View{
    public static function render($view, $args=[]){
      //extract vars from args[]
      foreach($args as $key => $val){
        if(preg_match("/^[^a-z]+/", $key)){ //exception handling
          echo "View::render()>> wow, '$key' is invalid for var name!";
          continue;
        }
        $$key = $val;
      }

      $file = "../Apps/Views/$view"; //relative to Core Directory

      if(is_readable($file)){
        require $file;
      }
      else{
        //echo "View::render()>> $file not found";
        throw new \Exception("View::render()>> $file not found");
      }
    }

    public static function renderTemplate($template, $args=[]){
      static $twig = null;

      if($twig === null){
        $loader = new \Twig_Loader_Filesystem(dirname(__DIR__). '/Apps/Views');
        $twig = new \Twig_Environment($loader);
      }

      echo $twig->render($template, $args);
    }
  }

 ?>
