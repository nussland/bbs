<?php
/**
 * getUsername.php
 *
 * Created on 15. 4. 29
 * @author: hskim
 */
$conn = new SQLite3('/var/db/bbs.db', SQLITE3_OPEN_READONLY);
$sql = "select * from user";
$result = $conn->query($sql);

while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $val[] = $row;
}
$jsonData = json_encode($val);
echo $jsonData;