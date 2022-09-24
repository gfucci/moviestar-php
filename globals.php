<?php

    $BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"] . "?") . "/";

    error_reporting(E_ALL);

    ini_set("display_errors", 1);