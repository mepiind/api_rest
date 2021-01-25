<?php
global $routes;
$routes = array();

$routes['/noticias'] = '/noticias/getNoticias';
$routes['/noticias/new'] = '/noticias/newNoticia';
$routes['/noticias/delete/{id}'] = '/noticias/deletaNoticia/:id';
$routes['/noticias/{id}'] = '/noticias/manipulaNoticia/:id';

$routes['/normas'] = '/normas/getNormas';
$routes['/normas/new'] = '/normas/newNorma';
$routes['/normas/delete/{id}'] = '/normas/deletaNorma/:id';
$routes['/normas/{id}'] = '/normas/manipulaNorma/:id';

$routes['/menus'] = '/menus/getMenus';
$routes['/menus/new'] = '/menus/newMenu';
$routes['/menus/tipo/{id}'] = '/menus/getMenusTipo/:id';
$routes['/menus/delete/{id}'] = '/menus/deletaMenu/:id';
$routes['/menus/categoria/pai/{id}'] = '/menus/getMenusCategoriaPai/:id';
$routes['/menus/categoria/{id}'] = '/menus/getMenusCategoria/:id';
$routes['/menus/{id}'] = '/menus/manipulaMenu/:id';

$routes['/produtos'] = '/produtos/getProdutos';
$routes['/produtos/new'] = '/produtos/newProduto';
$routes['/produtos/delete/{id}'] = '/produtos/deletaProduto/:id';
$routes['/produtos/categoria/{id}'] = '/produtos/getProdutoCategoria/:id';
$routes['/produtos/{id}'] = '/produtos/manipulaProduto/:id';

$routes['/itensDatabooks'] = '/itensDatabooks/getItensDatabooks';
$routes['/itensDatabooks/new'] = '/itensDatabooks/newItensDataBook';
$routes['/itensDatabooks/databook'] = '/itensDatabooks/getItensDataBooksDatabook';
$routes['/itensDatabooks/{id}'] = '/itensDatabooks/manipulaItensDataBook/:id';

$routes['/clientes'] = '/clientes/getClientes';
$routes['/clientes/new'] = '/clientes/newCliente';
$routes['/clientes/delete/{id}'] = '/clientes/deletaCliente/:id';
$routes['/clientes/{id}'] = '/clientes/manipulaCliente/:id';


$routes['/setores/cliente/users'] = '/setores/getSetoresCliente';

$routes['/setores/clientes/{id}'] = '/setores/getSetoresClientes/:id';
$routes['/setores'] = '/setores/getSetores';
$routes['/setores/new'] = '/setores/newSetor';
$routes['/setores/delete/{id}'] = '/setores/deletaSetor/:id';
$routes['/setores/{id}'] = '/setores/manipulaSetor/:id';

$routes['/catalogos'] = '/catalogos/getCatalogos';
$routes['/catalogos/new'] = '/catalogos/newCatalogos';
$routes['/catalogos/delete/{id}'] = '/catalogos/deletaCatalogos/:id';
$routes['/catalogos/{id}'] = '/catalogos/manipulaCatalogos/:id';


$routes['/cadastro/{id}'] = '/cadastro/index/:id';

$routes['/users/login'] = '/users/login';
$routes['/users/login/admin'] = '/users/loginAdmin';
$routes['/users/new/{id}'] = '/users/manipulaUsers/:id';

$routes['/mail/send'] = '/mail/send';
$routes['/mail/notification'] = '/mail/notification';

$routes['/dataBooks'] = '/dataBooks/getDataBooks';
$routes['/dataBooks/new'] = '/dataBooks/newDataBook';
$routes['/dataBooks/delete/{id}'] = '/dataBooks/deleteDataBooks/:id';
$routes['/dataBooks/setores'] = '/dataBooks/getDataBookSetores';
$routes['/dataBooks/{id}'] = '/dataBooks/manipulaDataBook/:id';

$routes['/ItensDatabooks'] = '/ItensDatabooks/getDataBooks';
$routes['/ItensDatabooks/new'] = '/ItensDatabooks/newDataBook';
$routes['/ItensDatabooks/delete/{id}'] = '/ItensDatabooks/deleteDataBooks/:id';
$routes['/ItensDatabooks/{id}'] = '/ItensDatabooks/manipulaItensDataBook/:id';

$routes['/upload'] = '/upload/saveUpload';