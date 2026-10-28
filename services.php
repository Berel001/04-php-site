<?php
declare(strict_types=1);

$pageTitle = 'Services';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-banner">
        <div class="container">
            <p class="eyebrow">What we do</p>
            <h1>Cleaning services for the spaces you use every day.</h1>
            <p>Choose from our cleaning services, then get in touch to make a plan that suits your space.</p>
        </div>
    </section>

    <section class="section container">
        <div class="service-grid">
            <?php foreach ($services as $service): ?>
                <?= renderServiceCard($service) ?>
            <?php endforeach; ?>
        </div>
        <p class="service-note">Every space is different. Contact us for a tailored plan and a free quote.</p>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
