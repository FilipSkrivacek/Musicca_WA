<?php
require_once 'include/dbConnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_stmt = $db->getConnection()->prepare("SELECT username, email FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

$article_stmt = $db->getConnection()->prepare("SELECT id, title, created_at FROM articles WHERE author_id = ?");
$article_stmt->bind_param("i", $user_id);
$article_stmt->execute();
$article_result = $article_stmt->get_result();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        
        $update_stmt = $db->getConnection()->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $username, $email, $user_id);
        
        if ($update_stmt->execute()) {
            $success = 'Profil úspěšně aktualizován.';
            $_SESSION['username'] = $username; // Aktualizace uživatelského jména v session
        } else {
            $error = 'Nepodařilo se aktualizovat profil. Zkuste to prosím znovu.';
        }
    }

    if (isset($_POST['delete'])) {
        $delete_ids = $_POST['delete_ids'] ?? [];
        if (!empty($delete_ids)) {
            $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
            $types = str_repeat('i', count($delete_ids));
            $stmt_delete = $db->getConnection()->prepare("DELETE FROM articles WHERE id IN ($placeholders)");
            $stmt_delete->bind_param($types, ...$delete_ids);
            $stmt_delete->execute();
            header("Location: profile.php");
            exit();
        }
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
    <title>Váš profil - Musicca</title>
    <link rel="icon" type="image/x-icon" href="assets/ikona.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigace-->
    <?php include 'include/navigation.php'; ?>
    <!-- Záhlaví stránky-->
    <header class="masthead" style="background-image: url('assets/img/contact.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Váš profil</h1>
                        <span class="subheading">Upravit údaje a spravovat příspěvky</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Hlavní obsah-->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <h2>Upravit údaje</h2>
                <form method="POST" action="profile.php">
                    <div class="form-floating">
                        <input class="form-control" id="username" type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required />
                        <label for="username">Uživatelské jméno</label>
                    </div>
                    <div class="form-floating">
                        <input class="form-control" id="email" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
                        <label for="email">Email</label>
                    </div>
                    <br />
                    <button class="btn btn-primary text-uppercase" type="submit" name="update_profile">Aktualizovat</button>
                </form>
                <br />
                <h2>Vaše příspěvky</h2>
                <form method="POST" action="profile.php">
                    <div class="list-group">
                        <?php while ($row = $article_result->fetch_assoc()): ?>
                            <div class="list-group-item">
                                <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>">
                                <a href="post.php?id=<?php echo $row['id']; ?>">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($row['title']); ?></h5>
                                </a>
                                <small>Vytvořeno <?php echo date('F j, Y', strtotime($row['created_at'])); ?></small>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <br />
                    <button type="submit" name="delete" class="btn btn-danger">Odstranit vybrané</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Patička-->
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
