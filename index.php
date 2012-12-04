<?php
/*
 * SimplePHPRedirector
 *
 * Written By: Jeff Lee
 * Date Created: 2012/04/28
 */

	$route = array(
		'' => 'home_page.php',

		'g' => array(
			'' => 'http://google.com/',
			'm' => 'https://gmail.com',
			'c' => 'https://www.google.com/calendar/render',
			'd' => 'https://drive.google.com'
		),

		'fb' => 'project/facebook',

		'urly' => 'http://urly.cc',
	);

	$errorPage = "ErrorPage/404.php";

	function handle_request($url, $sub) {
		// Sub folder: if old URL has deeper path, attach the rest to the new URL
		if (is_array($sub)) {
			array_shift($sub);
			array_shift($sub);
			$url .= "/" . implode("/", $sub);

			if (substr($url, 0, 4) != "http") {
				$url = "/" . $url;
			}
		}

		// Get request: copy same thing to the end of the new URL
		if (!empty($_SERVER['QUERY_STRING'])) {
			$url .= '?' . $_SERVER['QUERY_STRING'];
		}

		// Post request: resend the form data to the new URL
		// Only for Ajax requests
		if (!empty($_POST)) {
			//open connection
			$ch = curl_init(rtrim($url, "/"));

			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);

			return ;
		}

		header("Location: " . $url);
	}

	function route($uri, $route) {
		global $errorPage;

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

		include($errorPage);
	}

	route(explode("/", $_SERVER['REDIRECT_URL']), $route);
?>
