<?php

  namespace Core;

  class Router{
    //properties
    protected $routingTable = []; //@array
    protected $params;

    /*
      *what it does: add route to routing table
      *@param $route(string): route url
      *{controller}: controller param
      *{action}: action param
      *{sth:regex}: custom param form ('sth' represents param name, 'regex' binds 'sth' data format)
    */
    public function add($route, $params = []){
      //*--convert $route to regex form ({controller}/{action})
      //add '\' before '/' to make it regex-able ({controller}\/{action})
      $route = preg_replace("/\//", '\\/', $route);
      //make params regex-able
      $route = preg_replace("/\{([a-z-]+)\}/i", '(?<\1>[a-z-]+)', $route);
      //make custom params regex-able
      $route = preg_replace("/\{([a-z-]+):([^\{\}]+)\}/i", '(?<\1>\2)', $route);
      //add /^ and $/i to make it complete regex format
      $route = '/^'. $route. '$/i';

      //pass $route and its $params to routingTable
      $this->routingTable[$route] = $params;
    }

    /*
      *what it does: match url with routingTable & parse the match to $params
      *@param $url(url): url
      *return: true(match found), false(match not found)
    */
    public function match($url){
      foreach($this->routingTable as $route => $params){
        if(preg_match($route, $url, $matchedData)){
          foreach($matchedData as $key => $val){
            //parse string-key to $params so that you can exclude number-indexed ones
            if(is_string($key)){
              $params[$key] = $val;
            }
          }

          $this->params = $params;
          return true;
        }
      }

      return false;
    }

    public function dispatch($url){
      $url = $this->removeQueryStringVariables($url);

      if($this->match($url)){
        $controller = $this->params['controller'];
        $controller = $this->toStudlyCaps($controller);
        $controller = $this->getNameSpace().$controller;

        if(class_exists($controller)){
          $obj_controller = new $controller($this->params);

          $action = $this->params['action'];
          $action = $this->toCamelCase($action);

          if(is_callable([$obj_controller, $action])){
            $obj_controller->$action();
          }
          else{
            //echo "Method $action (in controller $controller) not found";
            throw new \Exception("Method $action (in controller $controller) not found");
          }
        }
        else{
          //echo "Controller class $controller not found";
          throw new \Exception("Controller class $controller not found");
        }
      }
      else{
        //echo "No route matched (url:$url)";
        throw new \Exception("No route matched (url:$url)", 404);
      }
    }

    //remove query string var (../posts/index"?view=2"<- this part, '?' is converted to '&' through $_SERVER)
    protected function removeQueryStringVariables($url){
      if($url != ''){
        $parts = explode('&', $url, 2);

        if(strpos($parts[0], '=') === false){
          $url = $parts[0];
        }
        else{
          $url = '';
        }
      }

      return $url;
    }

    //get namespace for controler class if specified in index.php (needed if sub folder is made inside 'Controllers' folder)
    protected function getNameSpace(){
      $namespace = 'Apps\Controllers\\';
      if(array_key_exists('namespace', $this->params)){
        $namespace .= $this->params['namespace']. '\\';
      }

      return $namespace;
    }

    private function toStudlyCaps($string){
      return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    private function toCamelCase($string){
      return lcfirst($this->toStudlyCaps($string));
    }

    //set & get
    public function getRoutingTable(){
      return $this->routingTable;
    }
    public function getParams(){
      return $this->params;
    }
  }
 ?>
