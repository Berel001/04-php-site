<?php
declare(strict_types=1);

$pageTitle = 'About';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-banner">
        <div class="container">
            <p class="eyebrow">A little about us</p>
            <h1>Good cleaning starts with good people.</h1>
            <p>Meet the people who make every visit feel thoughtful and dependable.</p>
        </div>
    </section>

    <section class="section container">
        <div class="section-heading">
            <p class="eyebrow">Our approach</p>
            <h2>Care you can see. Service you can count on.</h2>
            <p>Our team works carefully, communicates clearly, and helps each space feel just right.</p>
        </div>
        <div class="team-grid">
            <?php foreach ($team as $member): ?>
                <article class="team-card">
                    <h3><?= e($member['name']) ?></h3>
                    <p class="team-role"><?= e($member['role']) ?></p>
                    <p><?= e($member['bio']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
