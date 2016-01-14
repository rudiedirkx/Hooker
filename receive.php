<?php

echo $_POST ? "QUERY:\n" : "JSON:\n";
$data = $_POST ?: json_decode(file_get_contents('php://input'), true);
print_r($data);

if (isset($data['delay'])) {
	sleep(2 * $data['delay']);
}
