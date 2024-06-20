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
$stmt = $db->getConnection()->prepare("SELECT articles.title, articles.content, articles.image, users.username, articles.created_at, articles.author_id FROM articles JOIN users ON articles.author_id = users.id WHERE articles.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$post = $result->fetch_assoc();

// Zpracování komentáře
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    
    $stmt_comment = $db->getConnection()->prepare("INSERT INTO comments (article_id, author_id, content) VALUES (?, ?, ?)");
    $stmt_comment->bind_param("iis", $post_id, $user_id, $content);
    $stmt_comment->execute();
}

// Načtení komentářů
$stmt_comments = $db->getConnection()->prepare("SELECT comments.content, comments.created_at, users.username FROM comments JOIN users ON comments.author_id = users.id WHERE comments.article_id = ? ORDER BY comments.created_at DESC");
$stmt_comments->bind_param("i", $post_id);
$stmt_comments->execute();
$comments = $stmt_comments->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt_delete = $db->getConnection()->prepare("DELETE FROM articles WHERE id = ?");
    $stmt_delete->bind_param("i", $post_id);
    $stmt_delete->execute();
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo htmlspecialchars($post['title']); ?> - Musicca</title>
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
    <header class="masthead" style="background-image: url('uploads/<?php echo htmlspecialchars($post['image']); ?>')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                        <span class="meta">Vytvořeno uživatelem <?php echo htmlspecialchars($post['username']); ?> on
                            <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Post Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['author_id']): ?>
                        <form method="POST" action="post.php?id=<?php echo $post_id; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Smazat příspěvek</button>
                            <a href="edit_post.php?id=<?php echo $post_id; ?>" class="btn btn-primary">Upravit příspěvek</a>
                        </form>
                    <?php endif; ?>

                    <!-- Komentáře -->
                    <section class="mb-4">
                        <h3>Komentáře</h3>
                        <?php while ($comment = $comments->fetch_assoc()): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p class="card-text"><?php echo htmlspecialchars($comment['content']); ?></p>
                                    <small class="text-muted">Vytvořeno uživatelem <?php echo htmlspecialchars($comment['username']); ?> dne <?php echo date('F j, Y', strtotime($comment['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <!-- Přidat komentář -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="post.php?id=<?php echo $post_id; ?>">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="content" name="content" placeholder="Zanechte komentář" style="height: 100px" required></textarea>
                                    <label for="content">Zanechte komentář</label>
                                </div>
                                <button type="submit" name="comment" class="btn btn-primary">Přidat komentář</button>
                            </form>
                        <?php else: ?>
                            <p>Pro přidání komentáře se prosím <a href="login.php">přihlaste</a>.</p>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </article>
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
