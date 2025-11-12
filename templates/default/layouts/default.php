<?php
require_once __DIR__ . '/../../../core/settings.php';

$settings = get_site_settings();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? htmlspecialchars($settings['site_name'])) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? '') ?>">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Chicle" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- Background -->
    <style>
        body {
            background-image: url("<?= asset('image/leaft.png') ?>");
            background-repeat: repeat-x;
            background-position: top;
            background-attachment: scroll;
        }
    </style>
</head>

<body class="d-flex flex-column">

    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container flex-grow-1 my-3">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <aside class="sidebar sticky-top" style="top: 1rem;">
                    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <main>
                    <div id="hold" class="content-box">
                        <?= $page_content ?>
                    </div>
                </main>
            </div>
        </div>

        <!-- <?php include __DIR__ . '/../partials/landscape.php'; ?> -->

    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>