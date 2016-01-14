<?php

file_put_contents('./hooks/' . microtime(1) . '.json', json_encode(array(
	'url' => 'https://home.hotblocks.nl/tests/hooker/receive.php',
	'format' => rand(0, 1) ? 'json' : 'query',
	'data' => array(
		'whatever' => rand(),
		'delay' => rand(1, 4),
	),
)));
