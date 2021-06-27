<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Жанры</title>
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
        <h4>Жанры</h4>
        <form action="" method="post">
            <label for="genre">Жанр</label>
            <input type="text" name="genre">
            <input type="submit">
        </form>
        <?php
        require_once('connection.php');
        if (!empty($_POST))
        {
            $genre = $_POST['genre'];
            $query = "INSERT INTO `genres` (`genre`)
                      VALUES (:genre)";
            $stmt = $link->prepare($query);
            $data = array(
                'genre' => "$genre",
            );
            $stmt->execute($data);
        }
        $query = "SELECT * FROM `genres`";
        $stmt = $link->query($query);

        echo "<table><tr>
            <th>ID</th>
            <th>Жанр</th>
            </tr>";
            
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['genre'].'</td>
            </tr>';
        }
        ?>
    </body>
</html>