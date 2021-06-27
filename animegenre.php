<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <?php
        require_once('connection.php');
        ?>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>База данных аниме</h2>
        <nav>
            <a class="nav" href="index.php">Главная</a>
            <a class="nav" href="animegenre.php">Аниме по жанрам</a>
            <a class="nav" href="animestudio.php">Аниме по студии</a>
            <a class="nav" href="types.php">Типы</a>
            <a class="nav" href="genres.php">Жанры</a>
            <a class="nav" href="studios.php">Студии</a>
        </nav>
        
        <!-- Форма выбора жанра аниме -->
        <section>
            <form action="" method="post">
                <label for="anime_genre">Выбрать жанр: </label>
                <select name="anime_genre">
                <?php
                $query = "SELECT * FROM `genres`";
                $stmt = $link->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<option value="'.$row['id'].'">'.$row['genre'].'</option>';
                }
                ?>
                </select>
                <input type="submit" value="Показать">
            </form>
        </section>

        <?php
        if (!empty($_POST))
        {
            echo '<section>';
            $genre_id = $_POST['anime_genre'];
            $query = "SELECT anime.anime_id, anime.title, genres.genre FROM `animegenre`
                    INNER JOIN `genres` ON genres.id=genre_id
                    INNER JOIN `anime` ON anime.anime_id=animegenre.anime_id
                    WHERE genre_id=$genre_id
                    ORDER BY anime.title ASC";
            $stmt = $link->query($query);

            echo "<table><tr>
            <th>Название аниме</th>
            </tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>
                    <td><a href="anime.php?anime_id='.$row['anime_id'].'">'.$row['title'].'</a></td>
                    </tr>';
            }
            echo '</section>';
        }
        ?>
    </body>
</html>