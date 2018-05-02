<?php

  namespace Apps\Controllers;

  use \Core\View;
  use Apps\Models\Post;

  class Posts extends \Core\Controller{
    public function index_action(){
      $posts = Post::getAll();

      View::renderTemplate('Posts/index.html', ['posts' => $posts]);
    }

    public function addNew_action(){
      View::renderTemplate('Posts/addNew.html');
    }

    public function drawParams_action(){
      echo '<p>Posts::drawParams()>>route_params: <pre>'.print_r($this->route_params, true).'</pre></p>';
    }
  }
 ?>
