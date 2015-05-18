<?php
/**
 * comment.php
 *
 * Created on 15. 5. 11
 * @author: hskim
 *
CREATE TABLE comment (
idx int unsigned primary key,
boardIdx int unsigned primary key,
userId varchar(20) not null default '',
name varchar(20) not null default '',
passwd varchar(20) not null default '',
email varchar(50) not null default '',
note text not null,
regdate int unsigned not null default 0,
modDate int unsigned not null default 0,
flagDelete varchar(1) not null default 'N');
 *
CREATE TABLE comment (
idx INTEGER primary key,
boardIdx INTEGER,
userId TEXT,
name TEXT,
passwd TEXT,
email TEXT,
note TEXT,
regdate INTEGER default 0,
modDate INTEGER default 0,
flagDelete TEXT default 'N');
 *
CREATE INDEX commentIdx01 ON comment(boardIdx);
CREATE INDEX commentIdx02 ON comment(userId);
 */

namespace Action\Board;

use Action;
use DB;

class Comment extends Action\Base {
	public function getList($f3, $params) {
		$value = array();
		$boardIdx = $params['boardIdx'];
		$more = $params['more'];
		$where = array("boardIdx = ? AND flagDelete = ?", $boardIdx, "N");

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$list = $board->select(
			"idx, userId, name, note, regDate",
			$where,
			array(
				'order' => 'idx DESC',
				'limit' => POSTLIMIT,
				'offset' => ($more-1) * POSTLIMIT
			)
		);

		foreach ($list as $obj) {
			array_push($value, array(
				'idx' => $obj->idx,
				'userId' => $obj->userId,
				'name' => $obj->name,
				'note' => $obj->note,
				'regDate' => date('Y-m-d', $obj->regDate)
			));
		}

		echo json_encode($value);
	}

	public function getMore($f3, $params) {
		$value = array();
		$boardIdx = $params['boardIdx'];
		$page = $params['more'];
		$where = array("boardIdx = ? AND flagDelete = ?", $boardIdx, "N");

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$value['totalCnt'] = $board->count($where);
		$value['totalPage'] = floor($value['totalCnt']/10) + 1;
		$value['more'] = ($page + 1 < $value['totalPage']) ? $page + 1 : 0;

		echo json_encode($value);
	}

	public function add($f3) {
		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$board->boardIdx = $f3->get('POST.boardIdx');
		$board->name = $f3->get('POST.name');
		$board->passwd = $f3->get('POST.passwd');
		$board->note = $f3->get('POST.note');
		$board->regDate = time();

		$board->save();
	}

	public function modify($f3) {
		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$board->load(array('idx = ? AND passwd = ?', $f3->get('POST.idx'), $f3->get('POST.passwd')));

		if ($board->dry()) {
			echo 1;
		} else {
			$board->note = $f3->get('POST.note');
			$board->modDate = time();

			$board->save();
			echo 0;
		}
	}

	public function delete($f3) {
		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$board->load(array('idx = ? AND passwd = ?', $f3->get('POST.idx'), $f3->get('POST.passwd')));

		if ($board->dry()) {
			echo 1;
		} else {
			$board->flagDelete = "Y";
			$board->modDate = time();

			$board->save();
			echo 0;
		}
	}
}