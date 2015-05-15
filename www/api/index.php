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

$f3->route('GET /board/getList', 'Action\Board\Posts->getList');
$f3->route('GET /board/getPage', 'Action\Board\Posts->getPage');
$f3->route('GET /board/viewPost/@idx', 'Action\Board\Posts->viewPost');
$f3->route('POST /board/addPost', 'Action\Board\Posts->addPost');

$f3->run();