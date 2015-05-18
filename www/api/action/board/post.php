<?php
/**
 * posts.php
 *
 * Created on 15. 5. 11
 * @author: hskim
 *
CREATE TABLE board (
idx int unsigned primary key,
userId varchar(20) not null default '',
name varchar(20) not null default '',
passwd varchar(20) not null default '',
email varchar(50) not null default '',
title varchar(100) not null,
note text not null,
regDate int unsigned not null default 0,
modDate int unsigned not null default 0,
hit smallint unsigned not null default 0,
commentCnt smallint unsigned not null default 0,
fileCnt TINYINT unsigned not null default 0,
flagDelete varchar(1) not null default 'N');
 *
CREATE TABLE board (
idx INTEGER primary key,
userId TEXT,
name TEXT,
passwd TEXT,
email TEXT,
title TEXT,
note TEXT,
regDate INTEGER default 0,
modDate INTEGER default 0,
hit smallINTEGER default 0,
commentCnt INTEGER default 0,
fileCnt INTEGER default 0,
flagDelete TEXT default 'N');
 *
CREATE INDEX boardIdx01 ON board(userId);
CREATE INDEX boardIdx02 ON board(name);
CREATE INDEX boardIdx03 ON board(title);
 */
namespace Action\Board;

use Action;
use DB;

class Post extends Action\Base {
	public function getList($f3) {
		$value = array();
		$page = $f3->get('GET.page');
		$search = $f3->get('GET.search');
		$where = array("flagDelete = ?", "N");

		if ($search != '') {
			$where = array("flagDelete = ? AND (title LIKE ? OR name LIKE ?)", "N", $search."%", $search."%");
		}

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$list = $board->select(
			"idx, userId, name, title, regDate, hit, commentCnt",
			$where,
			array(
				'order' => 'idx DESC',
				'limit' => POSTLIMIT,
				'offset' => ($page-1) * POSTLIMIT
			)
		);

		foreach ($list as $obj) {
			array_push($value, array(
				'idx' => $obj->idx,
				'userId' => $obj->userId,
				'name' => $obj->name,
				'title' => $obj->title,
				'regDate' => date('Y-m-d', $obj->regDate),
				'hit' => $obj->hit,
				'commentCnt' => $obj->commentCnt
			));
		}

		echo json_encode($value);
	}

	public function getPage($f3) {
		$value = array();
		$page = $f3->get('GET.page');
		$search = $f3->get('GET.search');
		$where = array("flagDelete = ?", "N");

		if ($search != '') {
			$where = array("flagDelete = ? AND (title LIKE ? OR name LIKE ?)", "N", $search."%", $search."%");
		}

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$value['totalCnt'] = $board->count($where);
		$value['totalPage'] = floor($value['totalCnt']/10) + 1;

		$value['prev'] = ($page - 1 > 0) ? $page-1 : 1;
		$value['next'] = ($page + 1 < $value['totalPage']) ? $page + 1 : $value['totalPage'];

		$start = ($page - PAGELIMIT > 0) ? $page - PAGELIMIT : 1;
		$end = ($page + PAGELIMIT < $value['totalPage']) ? $page + PAGELIMIT : $value['totalPage'];

		for($i = $start; $i <= $end; $i++) {
			$value['pages'][] = $i;
		}

		echo json_encode($value);
	}

	public function view($f3, $params) {
		$value = array();

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$board->load(array('idx = ?', $params['idx']));
		$board->hit++;
		$board->save();

		$value['idx'] = $board->idx;
		$value['userId'] = $board->userId;
		$value['name'] = $board->name;
		$value['email'] = $board->email;
		$value['title'] = $board->title;
		$value['note'] = $board->note;
		$value['regDate'] = date('Y-m-d H:i:s', $board->regDate);
		$value['modDate'] = $board->modDate;
		$value['commentCnt'] = $board->commentCnt;
		$value['fileCnt'] = $board->fileCnt;

		echo json_encode($value);
	}

	public function add($f3) {
		$note = str_replace(' contenteditable="true"', '', $f3->get('POST.note'));

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$board->name = $f3->get('POST.name');
		$board->passwd = $f3->get('POST.passwd');
		$board->title = $f3->get('POST.title');
		$board->note = $note;
		$board->regDate = time();

		$board->save();
	}

	public function modify($f3) {
		$note = str_replace(' contenteditable="true"', '', $f3->get('POST.note'));

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$board->load(array('idx = ? AND passwd = ?', $f3->get('POST.idx'), $f3->get('POST.passwd')));

		if ($board->dry()) {
			echo 1;
		} else {
			$board->title = $f3->get('POST.title');
			$board->note = $note;
			$board->modDate = time();

			$board->save();
			echo 0;
		}
	}

	public function delete($f3) {
		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

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