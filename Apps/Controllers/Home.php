<?php

  namespace Apps\Controllers;

  use \Core\View;

  class Home extends \Core\Controller{
    public function index_action(){
      /*View::render('Home/index.php',[
        'name' => 'Yui',
        'coulours' => ['red', 'green', 'blue', 'orange']
      ]);*/
      View::renderTemplate('Home/index.html', [
        'name' => 'Dave',
        'colours' => ['red', 'green']
      ]);
    }

    protected function before(){
      //echo "(before)";
      //return false;
    }

    protected function after(){
      //echo "(after)";
    }
  }

 ?>
