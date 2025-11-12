<?php
require_once __DIR__ . '/../../config/cms.php';
require_once __DIR__ . '/../../core/settings.php';
require_once __DIR__ . '/../../core/functions.php';

if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

$error = '';
$username = '';
$settings = get_site_settings();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $error = lang('login.invalid_token');
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: /admin');
            exit;
        } else {
            $error = lang('login.invalid_credentials');
        }
    }
}

$title = lang('login.title');
ob_start();
?>

<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h1 class="h3 mb-1 fw-bold text-primary"><?= htmlspecialchars($settings['site_name']) ?></h1>
                        <p class="text-muted"><?= lang('login.admin_login') ?></p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label for="username" class="form-label"><?= lang('login.username') ?></label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="username" 
                                   name="username" 
                                   value="<?= htmlspecialchars($username ?? '') ?>" 
                                   required 
                                   autofocus>
                            <div class="invalid-feedback">
                                <?= lang('login.enter_username') ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label"><?= lang('login.password') ?></label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <div class="invalid-feedback">
                                <?= lang('login.enter_password') ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <?= lang('login.button') ?>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <?= lang('login.default_credentials') ?>
                        </small>
                    </div>

                </div>
            </div>

            <div class="text-center mt-4 text-muted">
                <small>&copy; <?= date('Y') . ' ' . CMS_NAME ?> . All rights reserved.</small>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap Validation -->
<script>
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?php
$page_content = ob_get_clean();

require_once __DIR__ . '/../layouts/login.php';
?>