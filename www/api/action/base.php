<?php
/**
 * base.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 */
namespace Action;

use DB;

define("POSTLIMIT", 10);
define("PAGELIMIT", 4);
define("COMMENTLIMIT", 5);

class Base {
    protected $db;

    public function __construct() {
        $db = new DB\SQL('sqlite:/var/db/bbs.db');
        $this->db = $db;
    }
}