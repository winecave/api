<?php
require 'database.php';
$raw = file_get_contents('php://input');
$request = json_decode($raw);
$type  = $request->{'type'};
$value = $request->{'value'};

if (insert($type, $value)) {
    echo "{'code': 200, 'request': $raw}";
} else {
    echo "{'code': 500, 'msg': 'insert error'}";
}
?>
