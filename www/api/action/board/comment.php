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
regDate int unsigned not null default 0,
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
regDate INTEGER default 0,
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
				'limit' => $more * COMMENTLIMIT,
				'offset' => 0
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

		$totalCnt = $board->count($where);
		$totalPage = floor($totalCnt / COMMENTLIMIT) + 1;
		$value['more'] = ($page + 1 <= $totalPage) ? $page + 1 : 0;
		$value['moreCount'] = ($value['more'] > 0) ? $totalCnt - ($page * COMMENTLIMIT) : 0;

		echo json_encode($value);
	}

	public function view($f3, $params) {
		$value = array();

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'comment');

		$board->load(array('idx = ?', $params['idx']));

		$value['idx'] = $board->idx;
		$value['userId'] = $board->userId;
		$value['name'] = $board->name;
		$value['email'] = $board->email;
		$value['note'] = $board->note;
		$value['regDate'] = date('Y-m-d H:i:s', $board->regDate);
		$value['modDate'] = $board->modDate;

		echo json_encode($value);
	}

	public function add($f3) {
		$db = $this->db;
		$comment = new DB\SQL\Mapper($db, 'comment');

		$comment->boardIdx = $f3->get('POST.boardIdx');
		$comment->name = $f3->get('POST.name');
		$comment->passwd = $f3->get('POST.passwd');
		$comment->note = $f3->get('POST.note');
		$comment->regDate = time();

		$comment->save();

		$board = new DB\SQL\Mapper($db, 'board');

		$board->load(array('idx = ?',  $f3->get('POST.boardIdx')));
		$board->commentCnt++;

		$board->save();

		$params['boardIdx'] = $f3->get('POST.boardIdx');
		$params['more'] = 1;
		$this->getList($f3, $params);
	}

	public function modify($f3) {
		$db = $this->db;
		$comment = new DB\SQL\Mapper($db, 'comment');

		$comment->load(array('idx = ? AND passwd = ?', $f3->get('POST.idx'), $f3->get('POST.passwd')));

		if ($comment->dry()) {
			echo 1;
		} else {
			$comment->note = $f3->get('POST.note');
			$comment->modDate = time();

			$comment->save();
			echo 0;
		}
	}

	public function delete($f3) {
		$db = $this->db;
		$comment = new DB\SQL\Mapper($db, 'comment');

		$comment->load(array('idx = ? AND passwd = ?', $f3->get('POST.idx'), $f3->get('POST.passwd')));

		if ($comment->dry()) {
			echo 1;
		} else {
			$comment->flagDelete = "Y";
			$comment->modDate = time();

			$comment->save();

			$board = new DB\SQL\Mapper($db, 'board');

			$board->load(array('idx = ?',  $f3->get('POST.boardIdx')));
			$board->commentCnt--;

			$board->save();
			echo 0;
		}
	}
}