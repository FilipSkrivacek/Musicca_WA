<?php
require_once 'include/dbConnection.php';
require_once 'include/UserManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $userManager = new UserManager($db);
    if ($userManager->registerUser($username, $email, $password)) {
        // Automatické přihlášení po úspěšné registraci
        $result = $userManager->login($email, $password);
        if ($result === true) {
            header("Location: index.php");
            exit();
        } else {
            $success = 'Registrace byla úspěšná, ale automatické přihlášení selhalo. Prosím, přihlaste se ručně.';
        }
    } else {
        $error = 'Registrace selhala. Zkuste to prosím znovu.';
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
    <title>Registrace - Musicca</title>
    <link rel="icon" type="image/x-icon" href="assets/ikona.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigace-->
    <?php
    $navPath = __DIR__ . '/include/navigation.php';
    if (file_exists($navPath) && is_readable($navPath)) {
        include $navPath;
    } else {
        echo 'Navigace není dostupná.';
    }
    ?>
    <!-- Záhlaví stránky-->
    <header class="masthead" style="background-image: url('assets/img/register.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>Registrace</h1>
                        <span class="subheading">Vytvoř si nový účet</span>
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
                    <form id="registerForm" method="POST" action="register.php">
                        <div class="form-floating">
                            <input class="form-control" id="username" type="text" name="username"
                                placeholder="Zadejte své uživatelské jméno..." required />
                            <label for="username">Uživatelské jméno</label>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" id="email" type="email" name="email"
                                placeholder="Zadejte svůj email..." required />
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" id="password" type="password" name="password"
                                placeholder="Zadejte své heslo..." required />
                            <label for="password">Heslo</label>
                        </div>
                        <br />
                        <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Registrovat</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
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
