Simple PHP Path Redirector
==========================

Redirect custom URL.

Usage
-----

Add your routes to the $route array.


Features
--------

* URL can have multiple levels

* If the URL has more levels than the defined routes, it will still redirect with the rest of URL append to the end

```Example:
$route = array(
	'hello' => array(
		'world' => 'path/to/hello/world'
	)
);

Then http://example.com/hello/world/i/am/jeff will go to http://example.com/path/to/hello/world/i/am/jeff
```

* GET Parameters are passed to the redirected URL

```Example:
$route = array(
	'test' => 'http://test.example.com/query'
);

Then http://example.com/test?id=2&name=jeff will go to http://test.example.com/query?id=2&name=jeff
```

* POST Parameters are executed, and results will be echoed.  Good for Ajax calls

```Example:
$route = array(
	'test' => 'http://test.example.com/update'
);

Then the POST data to http://example.com/test will be reposted to http://test.example.com/update,
if the http://test.example.com/update page returns OK, it will display OK.
```

Note
----

Since #hashFragment part of the URL is not passed to the server, can't really include that in the redirect URL.
