<?php
/**
 * bbsController.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 *
*/
$f3 = require('lib/base.php');
$f3->config('DEBUG', 2);
$f3->config('AUTOLOAD', 'action/');

$f3->route('GET /user/getList', 'Action\User\Info->getList');
$f3->route('POST /user/addUser', 'Action\User\Info->addUser');

$f3->route('GET /board/getList', 'Action\Board\Post->getList');
$f3->route('GET /board/getPage', 'Action\Board\Post->getPage');
$f3->route('GET /board/view/@idx', 'Action\Board\Post->view');
$f3->route('POST /board/add', 'Action\Board\Post->add');
$f3->route('POST /board/modify', 'Action\Board\Post->modify');
$f3->route('POST /board/delete', 'Action\Board\Post->delete');

$f3->route('GET /comment/getList/@boardIdx/@more', 'Action\Board\Comment->getList');
$f3->route('GET /comment/getMore/@boardIdx/@more', 'Action\Board\Comment->getMore');
$f3->route('GET /comment/view/@idx', 'Action\Board\Comment->view');
$f3->route('POST /comment/add', 'Action\Board\Comment->add');
$f3->route('POST /comment/modify', 'Action\Board\Comment->modify');
$f3->route('POST /comment/delete', 'Action\Board\Comment->delete');

$f3->run();