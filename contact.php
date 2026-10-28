<?php
$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-banner">
        <div class="container">
            <p class="eyebrow">Let's talk</p>
            <h1>Tell us about your space.</h1>
            <p>Get in touch with a few details and we’ll help you find the right clean.</p>
        </div>
    </section>

    <section class="section container contact-layout">
        <div class="contact-card">
            <p class="eyebrow">Contact details</p>
            <h2>We’d love to hear from you.</h2>
            <p>For a quote or a question about our services, send us an email. We’ll get back to you as soon as we can.</p>
            <a class="contact-email" href="mailto:<?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
        <aside class="contact-aside">
            <h3>Helpful to include</h3>
            <ul>
                <li>The type of space</li>
                <li>The service you’re interested in</li>
                <li>How often you’d like us to visit</li>
            </ul>
            <p>We’ll follow up to learn more and provide a tailored quote.</p>
        </aside>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
