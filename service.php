<?php
declare(strict_types=1);

$slug = $_GET['slug'] ?? '';
$service = null;

if (is_string($slug)) {
    require_once __DIR__ . '/includes/data.php';

    foreach ($services as $serviceItem) {
        if ($serviceItem['slug'] === $slug) {
            $service = $serviceItem;
            break;
        }
    }
}

if ($service === null) {
    http_response_code(404);
}

$pageTitle = $service === null ? 'Service not found' : $service['title'];
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <?php if ($service === null): ?>
        <section class="page-banner">
            <div class="container">
                <p class="eyebrow">404 - Service not found</p>
                <h1>We couldn’t find that service.</h1>
                <p>Please check the link or browse our available cleaning services.</p>
                <a class="button service-back-link" href="services.php">Browse services</a>
            </div>
        </section>
    <?php else: ?>
        <section class="page-banner">
            <div class="container">
                <p class="eyebrow">Service details</p>
                <h1><?= e($service['title']) ?></h1>
                <p><?= e($service['description']) ?></p>
            </div>
        </section>

        <section class="section container service-detail">
            <span class="service-icon" aria-hidden="true"><?= e($service['icon']) ?></span>
            <div>
                <p class="eyebrow">Starting price</p>
                <h2><?= e(formatPrice($service['price'])) ?></h2>
                <p>Final pricing may vary depending on the size and needs of your space.</p>
                <a class="button" href="contact.php">Ask for a tailored quote</a>
                <a class="service-back-link" href="services.php">Back to all services</a>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
