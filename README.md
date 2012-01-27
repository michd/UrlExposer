UrlExposer
==========

UrlExposer de-obfuscates shortened URLs by following the redirects and returning the URL when no more redirecting is happening (or a maximum number of redirects is reached)

It was written in PHP5.

Usage
-----

Include the UrlExposer class in your project. To expose a url, instantiate a new UrlExposer like so:

    $exposer = new UrlExposer($input_url);

You can now access properties `result_url`, `step_count` and `steps`, which are, in order:

-  The resulting url after following redirects
-  The number of redirects followed
-  An array with status codes and URLs of the steps undertaken


To be built 
-----------

-  An API to make it easy to use for other software.