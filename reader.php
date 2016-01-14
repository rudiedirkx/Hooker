<?php

if (!isset($_SERVER['argc'], $_SERVER['argv'])) {
	exit("This script MUST be run on the commandline.\n");
}

while (true) {

	// Read from ./hooks/
	$files = glob(__DIR__ . '/hooks/*.json');
	natsort($files);

	echo "\n\n\n\n" . date('Y-m-d H:i:s') . "\n";
	if ($files) {
		$file = array_shift($files);
		echo basename($file) . " (" . count($files) . ")\n\n";
		$meta = json_decode(file_get_contents($file), true);
		unlink($file);

		$data = $meta['format'] == 'json' ? json_encode($meta['data']) : http_build_query($meta['data']);

		$_time = microtime(1);

		$ch = curl_init($meta['url']);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Hooker (delayed webhook test)');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		// echo $result;
		// print_r($info);
		// echo "\n\n\n";

		$_spent = microtime(1) - $_time;
		echo "Request took: " . round($_spent * 1000) . " ms\n";
		echo "HTTP response: [" . $info['http_code'] . "] " . strlen((string) $result) . " bytes\n";

		echo "\n\n\n\n\n\n\n";

		sleep(1);
	}
	else {
		sleep(2);
	}

}
