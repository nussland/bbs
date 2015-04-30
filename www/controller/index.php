<?php
/**
 * bbsController.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 */
$f3 = require('lib/base.php');
$f3->config('DEBUG', 2);
$f3->config('AUTOLOAD', 'action/');

$f3->route('GET /user/getList', 'Action\User\Info->getList');
$f3->route('GET /user/addUser', 'Action\User\Info->addUser');

$f3->run();