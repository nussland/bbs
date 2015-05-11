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
        $value = array();

        $db = $this->db;
        $user = new DB\SQL\Mapper($db,'user');
        $user->load();

        do {
            array_push($value, $user->cast());
        } while($user->skip());

        echo json_encode($value);
    }

    public function addUser($f3) {
        $username = $f3->get('POST.username');

        $db = $this->db;
        $user = new DB\SQL\Mapper($db,'user');
        $user->set('username', $username);
        $user->save();

        $this->getList();
    }
}