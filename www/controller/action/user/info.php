<?php
/**
 * info.php
 *
 * Created on 15. 4. 30
 * @author: hskim
 */
namespace Action\User;

use Action;
use DB;

class Info extends Action\Base {
    public function getList() {
        $db = $this->db;
        $user = new DB\SQL\Mapper($db,'user');
        $list = $user->select('*');

        $val = array();
        $i = 0;

        foreach ($list as $obj) {
            $val[$i]['id'] = $obj->id;
            $val[$i]['username'] = $obj->username;
            $i++;
        }

        echo json_encode($val);
    }

    public function addUser($f3) {
        $username = $f3->get('GET.username');

        $db = $this->db;
        $user = new DB\SQL\Mapper($db,'user');
        $user->set('username', $username);
        $user->save();

        $this->getList();
        #$f3->reroute('/user/getList');
    }
}