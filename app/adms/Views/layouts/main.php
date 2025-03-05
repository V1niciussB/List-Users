<?php include 'app/adms/Views/partials/head.php' ?>

<body class="sb-nav-fixed d-flex flex-column min-vh-100">

    <?php include 'app/adms/Views/partials/navbar.php'; ?>

    <div id="layoutSidenav">
        <?php include 'app/adms/Views/partials/menu.php'; ?>

        <div id="layoutSidenav_content">
            <main>

                <?php include $this->view; ?>

            </main>

            <?php include 'app/adms/Views/partials/footer.php'; ?>
        </div>

    </div>
