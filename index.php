<?php
error_reporting(E_ALL & ~E_NOTICE);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'include/dbConnection.php';

$stmt = $db->getConnection()->prepare("SELECT articles.id, articles.title, articles.content, articles.image, users.username, articles.created_at FROM articles JOIN users ON articles.author_id = users.id ORDER BY articles.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Musicca</title>
    <link rel="icon" type="image/x-icon" href="assets/ikona.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php
    $navPath = __DIR__ . '/include/navigation.php';
    if (file_exists($navPath) && is_readable($navPath)) {
        include $navPath;
    } else {
        echo 'Navigace není dostupná.';
    }
    ?>
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('assets/img/indexbg.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Česká hudební scéna na jednom místě!</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <!-- Post preview-->
                        <div class="post-preview">
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                                <?php if (!empty($row['image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid">
                                <?php endif; ?>
                                <h2 class="post-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                                <h3 class="post-subtitle"><?php echo htmlspecialchars(substr($row['content'], 0, 150)); ?>...</h3>
                            </a>
                            <p class="post-meta">
                                Vytvořeno uživatelem
                                <a href="#!"><?php echo htmlspecialchars($row['username']); ?></a>
                                on <?php echo date('F j, Y', strtotime($row['created_at'])); ?>
                            </p>
                        </div>
                        <!-- Divider-->
                        <hr class="my-4" />
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="post-preview">
                        <h2>Vítej na Musicce!</h2>
                        <p>Naší nové hudební platformě, která ti přináší skvělý zážitek v oblasti hudby. Pokud jsi nováček, nemusíš se bát. Musicca je jednoduchá na použití a přístupná pro všechny, ať už jsi fanoušek, interpret nebo hudební manažer.</p>
                        <p>Na Musicce můžeš vytvořit svůj vlastní profil, nahrát svou hudbu a sdílet ji s ostatními. Platforma je navržena jako blog, což znamená, že kromě základních informací můžeš zveřejňovat příspěvky k různým tématům a interagovat s ostatními uživateli. Přihlašování je snadné a jen přihlášení uživatelé mohou přidávat své příspěvky.</p>
                        <p>Musicca ti umožňuje spravovat svůj profil a přidávat nové příspěvky, články a komentáře. Jako uživatel můžeš vytvářet, číst, upravovat a mazat svůj obsah. Administrátoři mají za úkol udržovat platformu čistou a přehlednou, takže se nemusíš bát nevhodného obsahu.</p>
                        <p><strong>Více se dozvíš na stránce <a href="about.php">o nás</strong></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
