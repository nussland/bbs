<?php
/**
 * base.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 */
namespace Action;

use DB;

class Base {
    protected $db;

    public function __construct() {
        $db = new DB\SQL('sqlite:/var/db/bbs.db');
        $this->db = $db;
    }
}