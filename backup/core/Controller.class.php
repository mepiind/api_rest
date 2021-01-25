<?php

 Class Controller {
  public function loadView($viewName, $viewData = array()){
    extract($viewData);
    require dirname(__FILE__,2) .'/' . 'views/' .$viewName;
  }

  public function loadTopo(){
    require dirname(__FILE__,2) .'/' . 'views/topo/topo.php';
  }

  public function loadTemplate($viewName, $viewData = array()){
    require dirname(__FILE__,2) .'/' . 'views/templates/templatePadrao.php';
  }

  public function loadViewInTemplate($viewName, $viewData = array()){
    extract($viewData);
    require dirname(__FILE__,2) .'/' . 'views/' .$viewName;
  }

}

?>
