<?php
/**
 * bbsController.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 */
/*
$conn = $db = new SQLite3('/var/db/bbs.db', SQLITE3_OPEN_READWRITE);
$db->exec('CREATE TABLE user (id INTEGER PRIMARY KEY, username VARCHAR(50))');
*/
$f3 = require('lib/base.php');
$f3->config('DEBUG', 2);
$f3->config('AUTOLOAD', 'action/');

$f3->route('GET /user/getList', 'Action\User\Info->getList');
$f3->route('POST /user/addUser', 'Action\User\Info->addUser');

$f3->run();