<?php

    require_once("templates/header.php");
    require_once("db.php");
    require_once("globals.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $movieDao = new movieDAO($conn, $BASE_URL);
    $reviewDao = new reviewDAO($conn, $BASE_URL);


    $id = filter_input(INPUT_GET, "id");

    $movie;

    if (empty($id)) {

        $message->setMessage("Filme não encontrado", "error");

    } else {

        $movie = $movieDao->findById($id);

        //verifica se o filme existe
        if (!$movie) {

            $message->setMessage("Filme não encontrado", "error");

        } 
    }

    //chegar se o filme tem imagem
    if ($movie-> image == "") {
        $movie->image = "movie_cover.jpg";
    }

    //chegar se o filme é do usuario
    $userOwnMovies = false;

    if (!empty($userData)) {

        if ($userData->id === $movie->users_id) {

            $userOwnMovies = true;
        }

        //already reviewed?
        $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
    }

    //resgatar review
    $moviesReview = $reviewDao->getMoviesReview($id);

?>  
    <div id="main-container" class="container-fluid">
        <div class="row">
            <div class="offset-md-1 col-md-6 movie-container">
                <h1 class="page-title">
                    <?= $movie->title ?>
                </h1>
                <p class="movie-details">
                    <span>Duração: <?= $movie->length ?></span>
                    <span class="pipe"></span>
                    <span><?= $movie->category ?></span>
                    <span class="pipe"></span>
                    <span><i class="fas fa-star"></i> <?= $movie->rating ?></span>
                </p>
                <iframe src="<?= $movie->trailer ?>" 
                    width="560" 
                    height="315"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
                <p><?= $movie->description ?></p>
            </div>
            <div class="col-md-4">
                <div 
                class="movie-image-container" 
                style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"
                ></div>
            </div>
            <div class="offset-md-1 col-md10" id="reviews-container">
                <h3 id="reviews-title">Avaliações:</h3>
                <!-- REVIEWS -->
                <?php if (!empty($userData) && !$alreadyReviewed && !$userOwnMovies): ?>
                    <div class="col-md-12" id="review-form-container">
                        <h4>Envie sua avaliação:</h4>
                        <p class="page-description">Preencha o formulário com a nota e comentário sobre o filme</p>
                        <form action="<?= $BASE_URL ?>review_process.php" method="POST" id="review-form">
                            <input type="hidden" name="type" value="create">
                            <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
                            <div class="form-group">
                                <label for="rating">Nota do filme:</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="">Selicione</option>
                                    <option value="10">10</option>
                                    <option value="9">9</option>
                                    <option value="8">8</option>
                                    <option value="7">7</option>
                                    <option value="6">6</option>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Seu comentário:</label>
                                <textarea 
                                    name="review" 
                                    id="review" 
                                    rows="3" 
                                    placeholder="O que você achou do filme?"
                                    class="form-control"
                                ></textarea>
                            </div>
                            <input type="submit" value="Enviar comentário" class="btn card-btn">
                        </form>
                    </div>
                <?php endif; ?>
                <!-- COMENTÁRIOS -->
                <?php foreach ($moviesReview as $review): ?>
                    <?php require("templates/user_review.php"); ?>
                <?php endforeach; ?>
                <?php if(count($moviesReview) == 0): ?>
                    <p class="empty-list">Não há reviews para este filme</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php

    require_once("templates/footer.php");

?>