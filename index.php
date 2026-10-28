<?php
declare(strict_types=1);

$pageTitle = 'Home';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="hero">
        <div class="container hero-content">
            <p class="eyebrow">Cleaning made simple</p>
            <h1>A cleaner space.<br>A little more time for you.</h1>
            <p class="hero-copy">
                From everyday home cleaning to a sparkling workplace, our friendly team
                takes care of the details so you can get on with your day.
            </p>
            <a class="button" href="contact.php">Request a free quote</a>
        </div>
    </section>

    <section class="section container">
        <div class="section-heading">
            <p class="eyebrow">Welcome to Prime Cleaners</p>
            <h2>Reliable cleaning, with care in every detail.</h2>
            <p>We bring a thoughtful, dependable approach to keeping the spaces you use looking their best.</p>
        </div>
        <div class="feature-grid">
            <article class="feature-card">
                <span class="feature-number">01</span>
                <h3>People you can trust</h3>
                <p>Our friendly cleaners treat your home and workplace with respect.</p>
            </article>
            <article class="feature-card">
                <span class="feature-number">02</span>
                <h3>A plan that fits</h3>
                <p>Choose a one-off visit or a regular schedule that works for you.</p>
            </article>
            <article class="feature-card">
                <span class="feature-number">03</span>
                <h3>Careful by nature</h3>
                <p>We focus on the little finishing touches that make a room feel fresh.</p>
            </article>
        </div>
    </section>

    <section class="callout">
        <div class="container callout-content">
            <div>
                <p class="eyebrow">Ready for a fresh start?</p>
                <h2>Tell us what you need cleaned.</h2>
            </div>
            <a class="button button-light" href="contact.php">Get in touch</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
