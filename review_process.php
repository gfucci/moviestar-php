<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("dao/ReviewDAO.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("models/Review.php");
    require_once("models/Message.php");
    
    $reviewDao = new ReviewDao($conn, $BASE_URL);
    $userDao = new UserDao($conn, $BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);

    $message = new Message($BASE_URL);

    //get type form
    $type = filter_input(INPUT_POST, "type");

    //get data user
    $userData = $userDao->verifyToken();

    if ($type === "create") {

    }