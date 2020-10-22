<?php
require_once('./App/Model/ConnectionDB.class.php');
require_once('./App/Model/Developer.class.php');
require_once('./App/Model/Game.class.php');
require_once('./App/Model/Platform.class.php');


$messageErrorTitle = null;
$messageErrorLink = null;
$messageErrorDate = null;


$connexionDataBaseVideoGames = ConnectionDB::connection();

if (isset($_GET['delete-id'])) {
    $deleteGame = fetchGameById($_GET['delete-id']);
    $deleteGame->delete();
    header('Location: /');
}

if (!empty($_POST)) {
    if ($_POST['title'] === '') {
        $messageErrorTitle = 'Il faut un titre';
    }
    if ($_POST['link'] === '') {
        $messageErrorLink = 'Il faut un lien';
    }
    if ($_POST['release_date'] === '') {
        $messageErrorDate = 'Il faut une date de sortie';
    }
    if ($_POST['title'] !== '' && $_POST['link'] !== '' && $_POST['release_date'] !== '') {
        $nouveauJeuVideo = new Game(null, $_POST['title'], $_POST['release_date'], $_POST['link'], $_POST['developer'], $_POST['platform']);
        $nouveauJeuVideo->create();
    }
}

$developers = fetchAllDevelopers();
$games = fetchAllGamesOrderBy();
$platforms = fetchAllPlatform();

if (isset($_GET['order-by-id']) && $_GET['order-by-id'] === 'desc') {
    $games = fetchAllGamesOrderBy('id', 'DESC');
}

if (isset($_GET['order-by-title']) && $_GET['order-by-title'] === 'desc') {
    $games = fetchAllGamesOrderBy('title', 'DESC');
} elseif (isset($_GET['order-by-title']) && $_GET['order-by-title'] === 'asc') {
    $games = fetchAllGamesOrderBy('title', 'ASC');
}

if (isset($_GET['order-by-date']) && $_GET['order-by-date'] === 'desc') {
    $games = fetchAllGamesOrderBy('release_date', 'DESC');
} elseif (isset($_GET['order-by-date']) && $_GET['order-by-date'] === 'asc') {
    $games = fetchAllGamesOrderBy('release_date', 'ASC');
}

if (isset($_GET['order-by-developer']) && $_GET['order-by-developer'] === 'desc') {
    $games = fetchAllGamesOrderBy('developer_id', 'DESC');
} elseif (isset($_GET['order-by-developer']) && $_GET['order-by-developer'] === 'asc') {
    $games = fetchAllGamesOrderBy('developer_id', 'ASC');
}

if (isset($_GET['order-by-platform']) && $_GET['order-by-platform'] === 'desc') {
    $games = fetchAllGamesOrderBy('platform_id', 'DESC');
} elseif (isset($_GET['order-by-platform']) && $_GET['order-by-platform'] === 'asc') {
    $games = fetchAllGamesOrderBy('platform_id', 'ASC');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />

<body>
    <div class="container">
        <div class="card text-center">
            <img src="images/data-original.jpg" class="card-img-top" alt="Retro gaming banner">
            <div class="card-header">
                <h1 class="mt-4 mb-4">My beautiful video games</h1>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#

                            <?php
                            if (!isset($_GET['order-by-id'])) {
                                echo "<a href='/?order-by-id=desc'>";
                            } else {
                                if ($_GET['order-by-id'] === 'desc') {
                                    echo "<a href='/?order-by-id=asc'>";
                                } else {
                                    echo "<a href='/?order-by-id=desc'>";
                                }
                            }
                            ?>

                            <i class="fas fa-sort-down"></i></a>
                        </th>
                        <th scope="col">Title

                            <?php
                            if (!isset($_GET['order-by-title'])) {
                                echo "<a href='/?order-by-title=desc'>";
                            } else {
                                if ($_GET['order-by-title'] === 'desc') {
                                    echo "<a href='/?order-by-title=asc'>";
                                } else {
                                    echo "<a href='/?order-by-title=desc'>";
                                }
                            }
                            ?>

                            <i class="fas fa-sort-down"></i></a>
                        </th>
                        <th scope="col">Release date

                            <?php
                            if (!isset($_GET['order-by-date'])) {
                                echo "<a href='/?order-by-date=desc'>";
                            } else {
                                if ($_GET['order-by-date'] === 'desc') {
                                    echo "<a href='/?order-by-date=asc'>";
                                } else {
                                    echo "<a href='/?order-by-date=desc'>";
                                }
                            }
                            ?>

                            <i class="fas fa-sort-down"></i></a>
                        </th>
                        <th scope="col">Developer

                            <?php
                            if (!isset($_GET['order-by-developer'])) {
                                echo "<a href='/?order-by-developer=desc'>";
                            } else {
                                if ($_GET['order-by-developer'] === 'desc') {
                                    echo "<a href='/?order-by-developer=asc'>";
                                } else {
                                    echo "<a href='/?order-by-developer=desc'>";
                                }
                            }
                            ?>

                            <i class="fas fa-sort-down"></i></a>
                        </th>
                        <th scope="col">Platform

                            <?php
                            if (!isset($_GET['order-by-platform'])) {
                                echo "<a href='/?order-by-platform=desc'>";
                            } else {
                                if ($_GET['order-by-platform'] === 'desc') {
                                    echo "<a href='/?order-by-platform=asc'>";
                                } else {
                                    echo "<a href='/?order-by-platform=desc'>";
                                }
                            }
                            ?>

                            <i class="fas fa-sort-down"></i></a>
                        </th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($games as $game) : ?>
                        <tr>
                            <th scope="row"><?= $game->getId() ?></th>
                            <td>
                                <a href=<?= $game->getLink() ?>><?= $game->getTitle() ?></a>
                            </td>
                            <td><?= $game->dateFormatChange() ?></td>
                            <td>
                                <a href=<?= $game->getDeveloper()->getLink() ?>><?= $game->getDeveloper()->getName() ?></a>
                            </td>
                            <td>
                                <a href=<?= $game->getPlatform()->getLink() ?>><?= $game->getPlatform()->getName() ?></a>
                            </td>
                            <td>
                                <a href="/?edit-id=<?= $game->getId() ?>"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>

                            </td>
                            <td>
                                <a href="/?delete-id=<?= $game->getId() ?>"><button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <form method="post">
                        <tr>
                            <th scope="row"></th>
                            <td>
                                <input type="text" name="title" placeholder="Title" />
                                <br />
                                <p style="color:red"><?= $messageErrorTitle ?></p>
                                <input type="text" name="link" placeholder="External link" />
                                <p style="color:red"><?= $messageErrorLink ?></p>
                            </td>
                            <td>
                                <input type="date" name="release_date" />
                                <p style="color:red"><?= $messageErrorDate ?></p>
                            </td>
                            <td>
                                <select name="developer">
                                    <?php foreach ($developers as $developer) : ?>
                                        <option value=<?= $developer->getId() ?>><?= $developer->getName() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="platform">
                                    <?php foreach ($platforms as $platform) : ?>
                                        <option value=<?= $platform->getId() ?>><?= $platform->getName() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td></td>
                        </tr>
                    </form>
                </tbody>
            </table>
            <div class="card-body">
                <p class="card-text">This interface lets you sort and organize your video games!</p>
                <p class="card-text">Let us know what you think and give us some love! 🥰</p>
            </div>
            <div class="card-footer text-muted">
                Created by <a href="https://github.com/M2i-DWWM-0920-Lyon-AURA">DWWM Lyon</a> &copy; 2020
            </div>
        </div>
    </div>
</body>

</html>