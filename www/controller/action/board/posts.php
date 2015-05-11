<?php
/**
 * posts.php
 *
 * Created on 15. 5. 11
 * @author: hskim
 *
 * CREATE TABLE board (
 * idxBoard int not null auto_increment primary key,
 * idxUser
 * name
 * passwd
 * email
 * title
 * note
 * dateReg
 * dateMod
 * cntHit
 * cntComment
 * cntFile
 * flagDelete
 *);
 * CREATE INDEX idx01 ON board(idxUser);
 * CREATE INDEX idx02 ON board(idxUser);
 * CREATE INDEX idx03 ON board(idxUser);
 * CREATE INDEX idx04 ON board(idxUser);
 */

namespace Action\Board;

use Action;
use DB;

class Posts extends Action\Base {
	public function getList() {
        $value = array();

        $db = $this->db;
        $board = new DB\SQL\Mapper($db, 'board');

        $list = $board->select('*');

        foreach ($list as $obj) {
            array_push($value, array(
                'id' => $obj->id,
                'username' => $obj->username));
        }

        echo json_encode($value);
    }

	public function getPost() {}

	public function addPost() {}

	public function modPost() {}

	public function delPost() {}

}