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

class Posts extends Action\Base {
	public function getList() {
		$value = array();

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$list = $board->select(
			"idx, userId, name, title, regDate, hit, commentCnt",
			"flagDelete = 'N'",
			array(
				'order' => 'idx ASC',
				'limit' => 10,
				'offset' => 0
			)
		);

		foreach ($list as $obj) {
			array_push($value, array(
				'idx' => $obj->idx,
				'userId' => $obj->userId,
				'name' => $obj->name,
				'title' => $obj->title,
				'regDate' => $obj->regDate,
				'hit' => $obj->hit,
				'commentCnt' => $obj->commentCnt
			));
		}

		echo json_encode($value);
	}

	public function getPost() {}

	public function addPost($f3) {

		$db = $this->db;
		$board = new DB\SQL\Mapper($db, 'board');

		$board->name =$f3->get('POST.name');
		$board->passwd = $f3->get('POST.passwd');
		$board->title = $f3->get('POST.title');
		$board->regDate = time();

		$board->save();

		//echo $f3->get('POST.name');
	}

	public function modPost() {}

	public function delPost() {}

}