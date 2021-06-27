<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>База данных аниме</title>
        <link rel="stylesheet" href="style.css">
        <?php require_once('connection.php'); ?>
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
        <section>
            <h4>Добавить аниме в базу данных</h4>
            <form action="" method="post">
                <label for="title">Название</label>
                <input type="text" name="title">
                <label for="anime_type">Тип</label>
                <select name="anime_type">
                <?php
                $query = "SELECT * FROM `types`";
                $stmt = $link->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<option value="'.$row['id'].'">'.$row['type'].'</option>';
                }
                ?>
                </select>
                <label for="description">Описание</label>
                <input type="text" name="description">
                <input type="submit">
            </form>
        </section>
        <?php
        if (!empty($_POST))
        {
            $title       = $_POST['title'];
            $type        = $_POST['anime_type'];
            $description = $_POST['description'];
            $query = "INSERT INTO `anime` (`title`, `type`, `description`)
                      VALUES (:title, :type, :description)";
            $stmt = $link->prepare($query);
            $data = array(
                'title' => "$title",
                'type' => "$type",
                'description' => "$description",
            );
            $stmt->execute($data);
        }
        $query = "SELECT * FROM `anime`
                  INNER JOIN `types` ON anime.type=types.id
                  LEFT JOIN `screenshots` ON anime.anime_id=screenshots.anime_screenshot_id AND screenshots.cover=1";
        $stmt = $link->query($query);
        echo "<table><tr>
              <th>ID</th>
              <th>Название</th>
              <th>Тип</th>
              <th>Описание</th>
              </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo '<tr">
            <td>'.$row['anime_id'].'</td>
            <td><a href="anime.php?anime_id='.$row['anime_id'].'">'.$row['title'].'</a><br><img class="cover" src="'.$row['screenshot_link'].'"></td>
            <td>'.$row['type'].'</td>
            <td>'.$row['description'].'</td>
            </tr>';
        }
        ?>      
    </body>
</html>