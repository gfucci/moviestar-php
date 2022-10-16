<?php

    require_once("dao/UserDAO.php");
    require_once("globals.php");
    require_once("db.php");

    $userDao = new userDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(false);

?>
    
    
<footer id="footer">
    <div id="social-container">
        <ul>
            <li>
                <a href="https://github.com/gfucci/moviestar-php" rel="noopener noreferrer" target="_blank">
                    <i class="fa-brands fa-github"></i>
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/gabrielfucci_/" rel="noopener noreferrer" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/in/gabrielfucci/" rel="noopener noreferrer" target="_blank">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </li>
        </ul>
    </div>
    <div id="footer-links-container">
        <ul>
            <?php if($userData): ?>
                <li>
                    <a href="<?= $BASE_URL ?>newMovie.php">Adicionar Filme</a>
                </li>
                <li>
                    <a href="<?= $BASE_URL ?>">Adicionar crítica</a>
                </li>
            <?php else: ?>
            <li>
                <a href="<?= $BASE_URL ?>auth.php">Entrar / Cadastrar</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <a id="copyright" href="https://gabrielfucci-portfolio.vercel.app/" rel="noopener noreferrer" target="_blank">&copy; 2022 Gabriel Fucci</a>
</footer>
</body>
</html>