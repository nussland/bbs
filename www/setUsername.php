<?php
/**
 * setUsername.php
 *
 * Created on 15. 4. 29
 * @author: hskim
 */

$conn = $db = new SQLite3('/var/db/bbs.db', SQLITE3_OPEN_READWRITE);
#$db->exec('CREATE TABLE user (id INTEGER, username TEXT)');

$id = $_GET['id'];
$username = $_GET['username'];

$sql = "insert into user values($id, '".$username."')";
$result = $conn->exec($sql);

$sql = "select * from user";
$result = $conn->query($sql);

while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $val[] = $row;
}
$jsonData = json_encode($val);
echo $jsonData;