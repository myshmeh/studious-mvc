<?php
  //composer
  require_once dirname(__DIR__). '/vendor/autoload.php';

  //error / exception handling
  error_reporting(E_ALL);
  set_error_handler('Core\Error::errorHandler');
  set_exception_handler('Core\Error::exceptionHandler');

  //twig
  Twig_Autoloader::register();

  //routing
  use \Core\Router;
  $router = new Router();

  //add new route to routingTable
  $router->add('', ['controller' => 'home', 'action' => 'index']);
  $router->add('index', ['controller' => 'home', 'action' => 'index']);
  $router->add('{controller}/{action}');
  $router->add('admin/{controller}/{id:[0-9]+}/{action}', ['namespace' => 'Admin']);
  $router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

  //matching url to routingTable
  $router->dispatch($_SERVER['QUERY_STRING']);

  //Display
/*
  echo '<hr><h3> ---index.php DISPLAY--- </h3>';

  echo "<h1>URL: ".$_SERVER['QUERY_STRING'].'</h1>';

  echo( '<hr><h2>Routing Table:</h2>' );
  echo( var_dump($router->getRoutingTable()) );
  echo '<br>';

  echo( '<hr><h2>Parameters:</h2>' );
  echo( var_dump($router->getParams()) );
  echo '<br>';


  echo '<p>Query String Parameters: <pre>'
    . htmlspecialchars(print_r($_GET, true)). '</pre></p>';
*/
 ?>
