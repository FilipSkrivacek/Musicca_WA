<?php
require_once 'include/dbConnection.php';
require_once 'include/UserManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

// Získání seznamu uživatelů a příspěvků
$users = $db->getConnection()->query("SELECT * FROM users");
$posts = $db->getConnection()->query("SELECT * FROM articles");

// Odstranění uživatele
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $stmt = $db->getConnection()->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $success = 'Uživatel úspěšně odstraněn.';
    } else {
        $error = 'Nepodařilo se odstranit uživatele.';
    }
}

// Odstranění příspěvku
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $stmt = $db->getConnection()->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    if ($stmt->execute()) {
        $success = 'Příspěvek úspěšně odstraněn.';
    } else {
        $error = 'Nepodařilo se odstranit příspěvek.';
    }
}

$users = $db->getConnection()->query("SELECT * FROM users");
$posts = $db->getConnection()->query("SELECT * FROM articles");
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Administrace - Musicca</title>
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
    <header class="masthead" style="background-image: url('assets/img/admin-bg.png')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>Administrace</h1>
                        <span class="subheading">Správa uživatelů a příspěvků</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Hlavní obsah-->
    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <h2>Uživatelé</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Uživatelské jméno</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <form method="POST" action="admin.php" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Odstranit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <h2>Příspěvky</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Název</th>
                                <th>Autor</th>
                                <th>Datum vytvoření</th>
                                <th>Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($post = $posts->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $post['id']; ?></td>
                                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td><?php echo htmlspecialchars($post['author_id']); ?></td>
                                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                                    <td>
                                        <form method="POST" action="admin.php" style="display:inline;">
                                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                            <button type="submit" name="delete_post" class="btn btn-danger btn-sm">Odstranit</button>
                                        </form>
                                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">Upravit</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- Patička-->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
