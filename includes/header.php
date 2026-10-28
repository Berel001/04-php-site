<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($tagline) ?>">
    <title><?= e($pageTitle) ?> | <?= e($siteName) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="index.php">
                <span class="brand-name"><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
                <span class="brand-tagline"><?= htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8') ?></span>
            </a>
            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <?php foreach ($navItems as $label => $fileName): ?>
                        <?php
                        $currentPage = basename($_SERVER['PHP_SELF']);
                        $isCurrentPage = $currentPage === $fileName
                            || ($fileName === 'services.php' && $currentPage === 'service.php');
                        ?>
                        <li>
                            <a href="<?= e($fileName) ?>"
                               class="<?= $isCurrentPage ? 'active' : '' ?>"
                               <?= $isCurrentPage ? 'aria-current="page"' : '' ?>>
                                <?= e($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>
