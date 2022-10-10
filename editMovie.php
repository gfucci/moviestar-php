<?php

    require_once("templates/header.php");
    require_once("db.php");
    require_once("globals.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $userDao = new userDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $id = filter_input(INPUT_GET, "id");

    if (empty($id)) {

        $message->setMessage("Filme não encontrado", "error");

    } else {

        $movie = $movieDao->findById($id);
        //print_r($movie); exit;

        //verifica se o filme existe
        if (!$movie) {

            $message->setMessage("Filme não encontrado", "error");

        } 
    }

    //chegar se o filme tem imagem
    if ($movie-> image == "") {
        $movie->image = "movie_cover.jpg";
    }

?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie->title ?></h1>
                    <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                    <form 
                        action="<?= $BASE_URL ?>movie_process.php"
                        method="POST"
                        enctype="multipart/form-data"
                        id="edit-movie-form"
                    >   
                        <input type="hidden" name="id" value="<?= $movie->id ?>">
                        <input type="hidden" name="type" value="update">
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="form-control"
                                placeholder="Digite o título do seu filme"
                                value="<?= $movie->title ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="image">Imagem:</label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                class="form-control-file"
                            >
                        </div>
                        <div class="form-group">
                            <label for="length">Duração</label>
                            <input 
                                type="length" 
                                name="length" 
                                id="image" 
                                class="form-control"
                                placeholder="Digite a duração do filme"
                                value="<?= $movie->length ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="category">Categorias:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Selecione</option>
                                <option 
                                    value="Ação" <?= $movie->category === "Ação" ? "Selected" : "" ?>
                                >Ação</option>
                                <option 
                                    value="Drama" <?= $movie->category === "Drama" ? "Selected" : "" ?>
                                >Drama</option>
                                <option 
                                    value="Comédia" <?= $movie->category === "Comédia" ? "Selected" : "" ?>
                                >Comédia</option>
                                <option 
                                    value="Romance" <?= $movie->category === "Romance" ? "Selected" : "" ?>
                                >Romance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trailer">Trailer:</label>
                            <input 
                                type="text" 
                                name="trailer" 
                                id="trailer" 
                                class="form-control"
                                placeholder="Insira o link do trailer"
                                value="<?= $movie->trailer ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea 
                                name="description" 
                                id="description"  
                                rows="5" 
                                class="form-control"
                                placeholder="<?= $movie->description ?>"      
                            ></textarea>
                        </div>
                        <input type="submit" value="Editar" class="btn card-btn">
                    </form>
                </div>
                <div class="col-md-3">
                    <div 
                        class="movie-image-container"
                        style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"
                    ></div>
                </div>
            </div>
        </div>
    </div>
<?php

    require_once("templates/footer.php");

?>