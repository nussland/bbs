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
CREATE INDEX idx01 ON board(userId);
CREATE INDEX idx02 ON board(name);
CREATE INDEX idx03 ON board(title);
 */
namespace Action\Board;

use Action;
use DB;

define("POSTLIMIT", 10);
define("PAGELIMIT", 4);

class Posts extends Action\Base {
	public function getList($f3, $params) {
		$value = array();

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$list = $board->select(
			"idx, userId, name, title, regDate, hit, commentCnt",
			"flagDelete = 'N'",
			array(
				'order' => 'idx DESC',
				'limit' => POSTLIMIT,
				'offset' => ($params['page']-1) * POSTLIMIT
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

	public function getPage($f3, $params) {
		$value = array();

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$value['totalCnt'] = $board->count();
		$value['totalPage'] = round($board->count()/10) + 1;

		$value['prev'] = ($params['page'] - 1 > 0) ? $params['page']-1 : 1;
		$value['next'] = ($params['page'] + 1 < $value['totalPage']) ?
			$params['page']+1 : $value['totalPage'];

		$start = ($params['page'] - PAGELIMIT > 0) ? $params['page'] - PAGELIMIT : 1;
		$end = ($params['page'] + PAGELIMIT < $value['totalPage']) ?
			$params['page'] + PAGELIMIT : $value['totalPage'];

		for($i = $start; $i <= $end; $i++) {
			$value['pages'][] = $i;
		}

		echo json_encode($value);
	}

	public function viewPost($f3, $params) {
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

	public function addPost($f3) {
		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$board->name =$f3->get('POST.name');
		$board->passwd = $f3->get('POST.passwd');
		$board->title = $f3->get('POST.title');
		$board->note = $f3->get('POST.note');
		$board->regDate = time();

		$board->save();
	}

	public function modPost() {}

	public function delPost() {}

}