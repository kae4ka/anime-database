<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <?php
            require_once('connection.php');
            if (!empty($_GET))
            {
                $anime_id = $_GET['anime_id'];
                $query = "SELECT title
                          FROM `anime`
                          WHERE anime_id = $anime_id";
                $stmt = $link->query($query);
                echo '<title>Студии ';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo $row['title'].'</title>';
                }
            }
            else
            {
                echo '<title>Студии по аниме</title>';
            }
        ?>
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

        <!-- Форма выбора студии аниме -->
        <section>
            <form action="" method="post">
                <label for="anime_studio">Выбрать студию: </label>
                <select name="anime_studio">
                <?php
                $query = "SELECT * FROM `studios`";
                $stmt = $link->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<option value="'.$row['id'].'">'.$row['studio'].'</option>';
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
            $studio_id = $_POST['anime_studio'];
            $query = "SELECT anime.anime_id, anime.title, studios.studio FROM `animestudio`
                    INNER JOIN `studios` ON studios.id=studio_id
                    INNER JOIN `anime` ON anime.anime_id=animestudio.anime_id
                    WHERE studio_id=$studio_id
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