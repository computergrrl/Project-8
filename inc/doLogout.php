<?php
require 'bootstrap.php';

//send a "bad cookie" in order to logout
$accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', getenv('COOKIE_DOMAIN'));
redirect('/', ['cookies' => [$accessToken]]);
