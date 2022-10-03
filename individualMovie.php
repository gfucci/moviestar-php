<?php

    require_once("templates/header.php");
    require_once("db.php");
    require_once("globals.php");
    require_once("dao/MovieDAO.php");

    $movieDao = new movieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    $movie;

    if (empty($id)) {

        $message->setMessage("Filme não encontrado", "error");

    } else {

        $movie = $movieDao->findById($id);

        if (!$movie) {

            $message->setMessage("Filme não encontrado", "error");

        } else {

        }
    }

?>

<?php

    require_once("templates/footer.php");

?>