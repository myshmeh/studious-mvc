<?php

namespace Apps\Controllers\Admin;

use \Core\View;

class Users extends \Core\Controller{
  protected function index_action(){
    echo 'Users::index_action()>> called';
  }

  protected function indexId_action(){
    View::renderTemplate('Users/index.html', $this->route_params);
  }
}

 ?>
