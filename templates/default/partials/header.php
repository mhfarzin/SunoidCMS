<?php
require_once __DIR__ . '/../../../core/settings.php';

$settings = get_site_settings();
?>

<header class="text-center">
    <h1 class="header-title">
        <?= htmlspecialchars($settings['site_name']) ?>
    </h1>
    <p class="header-subtitle mt-1">
        A CMS and Beautiful Content Management System
    </p>
</header>

<nav class="d-flex justify-content-center my-3">
    <ul class="nav custom-nav">
        <li class="nav-item">
            <a class="nav-link <?= ($slug ?? '') === 'home' ? 'active' : '' ?>" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($slug ?? '') === 'blog' ? 'active' : '' ?>" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/about">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/contact">Contact</a>
        </li>
    </ul>
</nav>

<?php
$hrText = "";
include __DIR__ . '/../partials/hr-text.php';
?>