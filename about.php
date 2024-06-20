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
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet" type="text/css" />
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
    <header class="masthead" style="background-image: url('assets/img/about.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>O nás</h1>
                    </div>
                </div>
            </div>
    </header>
    <!-- Main Content-->
    <main class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <p>Vítej na Musicce, naší nové hudební platformě, která ti přináší skvělý zážitek v oblasti hudby.
                        Pokud jsi nováček, nemusíš se bát. Musicca je jednoduchá na použití a přístupná pro všechny, ať
                        už jsi fanoušek, interpret nebo hudební manažer.</p>
                    <p>Na Musicce můžeš vytvořit svůj vlastní profil a je navržena jako blog, což znamená, že kromě základních informací můžeš zveřejňovat
                        příspěvky k různým tématům a interagovat s ostatními uživateli. Přihlašování je snadné a jen
                        přihlášení uživatelé mohou přidávat své příspěvky.</p>
                    <p>Musicca ti umožňuje spravovat svůj profil a přidávat nové příspěvky, články a komentáře. Jako
                        uživatel můžeš vytvářet, číst, upravovat a mazat svůj obsah. Administrátoři mají za úkol
                        udržovat platformu čistou a přehlednou, takže se nemusíš bát nevhodného obsahu.</p>
                    <p>Na Musicce najdeš také informace o nejnovějších hudebních akcích, párty a festivalech. S námi
                        budeš mít vždy přehled o tom, co se děje ve světě hudby. Ať už jde o malé koncerty nebo velké
                        festivaly, Musicca ti pomůže zůstat informovaný a nikdy nepropásnout žádnou skvělou akci.</p>
                    <p>Brzy spustíme také e-shop, kde budeš moci zakoupit různé druhy merche, jako jsou trička, mikiny a
                        čepice, a podpořit tak své oblíbené umělce.</p>
                    <p>Naši zákaznickou podporu můžeš kdykoliv kontaktovat s jakýmkoliv dotazem. Jsme tu, abychom ti
                        pomohli a zajistili, že tvůj zážitek s Musiccou bude co nejlepší. Tvůj spokojený zážitek je pro
                        nás na prvním místě, a proto se snažíme neustále zlepšovat naše služby.</p>
                    <p>Tak neváhej a připoj se k Musicce, nejlepší hudební platformě pro začátečníky i profesionály!
                        Objev nový svět hudby, najdi své oblíbené interprety a staň se součástí naší úžasné komunity.
                        Těšíme se na tebe!</p>

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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>