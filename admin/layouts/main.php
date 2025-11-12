<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Admin') ?></title>

  <link href="/admin/assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/admin/assets/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="/admin/assets/css/admin.css">

  <link rel="icon" href="/admin/assets/images/favicon.png">
</head>
<body>
  <div id="main-container" class="bg-light d-flex flex-column overflow-hidden">
      <?php include __DIR__ . '/../partials/header.php'; ?>

      <div id="main-content" class="container-fluid">
          <div class="row h-100">
              <?php include __DIR__ . '/../partials/sidebar.php'; ?>

              <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 h-100 overflow-auto">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                      <h1 class="h3 mb-0"><?= htmlspecialchars($title ?? '') ?></h1>
                  </div>

                  <?= $page_content ?>
              </main>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
