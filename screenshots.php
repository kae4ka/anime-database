<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <?php
            require_once('connection.php');
            $anime_id = $_GET['anime_id'];
            $query = "SELECT title FROM `anime` WHERE anime_id = $anime_id";
            $stmt = mysqli_query($link, $query);
        ?>
        <title>Кадры из <?php while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) { echo $row['title']; }?></title>
    </head>
    <body>
        <nav>
            <a href="index.php">Главная</a> |
            <a href="animegenre.php">Аниме по жанрам</a> |
            <a href="animestudio.php">Аниме по студии</a> |
            <a href="screenshots.php">Кадры</a>
        </nav>
        <?php   
            $query = "SELECT * FROM `screenshots` WHERE anime_screenshot_id = $anime_id";
            $stmt = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
            {
                echo '<img src='.$row['link'].'><br>';
            }
        ?>
    </body>
</html>