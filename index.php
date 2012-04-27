<?php

	$route = array(
		'' => 'Resume',

		'timetable' => 'about/docs/Timetable.pdf',

		'tcat' => array(
			'' => 'http://tcatoronto.com/',
			'mms' => 'http://tcatoronto.leejefon.com/member'
		),

		'fb' => 'project/facebook',
		'wu' => 'project/webutils',

		'wp' => 'http://blog.leejefon.com',
		'urly' => 'http://urly.cc',
	);

	$errorPage = "ErrorPage/404.php";

	function handle_request($url, $sub) {
		// Sub folder: if old URL has deeper path, attach the rest to the new URL
		if (is_array($sub)) {
			array_shift($sub);
			array_shift($sub);
			$url .= "/" . implode("/", $sub);
		}

		// Get request: copy same thing to the end of the new URL
		if (!empty($_SERVER['QUERY_STRING'])) {
			$url .= '?' . $_SERVER['QUERY_STRING'];
		}

		// Post request: resend the form data to the new URL
		// Only for Ajax requests
		if (!empty($_POST)) {
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, count($_POST));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);

			echo $result;

			return ;
		}

		header("Location: " . $url);
	}

	function route($uri, $route) {
		foreach ($route as $key => $val) {
			if ($uri[1] == $key) {
				if (is_array($val)) {
					array_shift($uri);
					route($uri, $val);
					return ;
				}

				handle_request($val, $uri);
				return ;
			}
		}

		include($errprPage);
	}

	route(explode("/", $_SERVER['REDIRECT_URL']), $route);
?>
