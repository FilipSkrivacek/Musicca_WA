<?php
require_once 'include/dbConnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = intval($_GET['id']);
$stmt = $db->getConnection()->prepare("SELECT title, content, image, author_id FROM articles WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$post = $result->fetch_assoc();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $post['author_id'] && $_SESSION['role'] !== 'ADMIN')) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $post['image']; // Přidáme kontrolu nahrání nového obrázku

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . $image_name;

        if (move_uploaded_file($image_tmp, $upload_file)) {
            $image = $image_name;
        }
    }

    $stmt_update = $db->getConnection()->prepare("UPDATE articles SET title = ?, content = ?, image = ? WHERE id = ?");
    $stmt_update->bind_param("sssi", $title, $content, $image, $post_id);

    if ($stmt_update->execute()) {
        header("Location: post.php?id=" . $post_id);
        exit();
    } else {
        $error = 'Nepodařilo se aktualizovat příspěvek. Zkuste to prosím znovu.';
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
    <title>Upravit příspěvek - Musicca</title>
    <link rel="icon" type="image/x-icon" href="assets/ikona.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
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
                    <div class="post-heading">
                        <h1>Upravit příspěvek</h1>
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
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form id="editForm" method="POST" action="edit_post.php?id=<?php echo $post_id; ?>" enctype="multipart/form-data">
                        <div class="form-floating">
                            <input class="form-control" id="title" type="text" name="title" placeholder="Nadpis" value="<?php echo htmlspecialchars($post['title']); ?>" required />
                            <label for="title">Nadpis</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" id="content" name="content" placeholder="Obsah článku" style="height: 12rem" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                            <label for="content">Obsah článku</label>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" id="image" type="file" name="image" placeholder="Nahrát obrázek" />
                            <label for="image">Nahrát obrázek (pokud chcete změnit)</label>
                        </div>
                        <br />
                        <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Upravit</button>
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
