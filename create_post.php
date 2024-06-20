<?php
require_once 'include/dbConnection.php';
require_once 'include/UserManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    // Zpracování nahrání obrázku
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . $image_name;

        // Kontrola a vytvoření složky, pokud neexistuje
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Přesun nahraného souboru
        if (move_uploaded_file($image_tmp, $upload_file)) {
            $stmt = $db->getConnection()->prepare("INSERT INTO articles (title, content, author_id, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $title, $content, $author_id, $image_name);

            if ($stmt->execute()) {
                header("Location: index.php"); // Přesměrování na hlavní stránku po úspěšném vytvoření článku
                exit();
            } else {
                $error = 'Nepodařilo se vytvořit příspěvek. Zkuste to prosím znovu.';
            }
        } else {
            $error = 'Nepodařilo se nahrát obrázek. Zkuste to prosím znovu.';
        }
    } else {
        $error = 'Prosím nahrajte obrázek.';
    }
}
?>


<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Vytvořit příspěvek - Musicca</title>
    <link rel="icon" type="image/x-icon" href="assets/ikona.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php include 'include/navigation.php'; ?>
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('assets/img/post.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>Vytvoř příspěvek</h1>
                        <span class="subheading">Napiš nám vše, co máš na jazyku</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form id="postForm" method="POST" action="create_post.php" enctype="multipart/form-data">
                        <div class="form-floating">
                            <input class="form-control" id="title" type="text" name="title" placeholder="Nadpis"
                                required />
                            <label for="title">Nadpis</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" id="content" name="content" placeholder="Obsah článku"
                                style="height: 12rem" required></textarea>
                            <label for="content">Obsah článku</label>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" id="image" type="file" name="image" placeholder="Nahrát obrázek"
                                required />
                            <label for="image">Nahrát obrázek</label>
                        </div>
                        <br />
                        <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Vytvořit</button>
                    </form>

                </div>
            </div>
        </div>
    </main>
    <!-- Footer-->
    <footer class="border-top">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>