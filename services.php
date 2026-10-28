<?php
$pageTitle = 'Services';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-banner">
        <div class="container">
            <p class="eyebrow">What we do</p>
            <h1>Cleaning services for the spaces you use every day.</h1>
            <p>Choose the service that suits you, then get in touch to make it your own.</p>
        </div>
    </section>

    <section class="section container">
        <div class="service-grid">
            <article class="service-card">
                <span class="service-label">For your home</span>
                <h2>Home cleaning</h2>
                <p>Regular or one-off cleaning to help keep your living spaces comfortable and fresh.</p>
                <ul>
                    <li>Kitchen and bathroom refresh</li>
                    <li>Dusting and surface cleaning</li>
                    <li>Vacuuming and floor care</li>
                </ul>
            </article>
            <article class="service-card">
                <span class="service-label">For your workplace</span>
                <h2>Office cleaning</h2>
                <p>Practical cleaning for welcoming workspaces, scheduled around your working day.</p>
                <ul>
                    <li>Shared areas and desks</li>
                    <li>Kitchens and washrooms</li>
                    <li>Bins and floor care</li>
                </ul>
            </article>
            <article class="service-card">
                <span class="service-label">A fresh beginning</span>
                <h2>Move-in cleaning</h2>
                <p>A detailed clean to help a new space feel ready for its next chapter.</p>
                <ul>
                    <li>Room-by-room attention</li>
                    <li>Inside accessible cupboards</li>
                    <li>Extra finishing touches</li>
                </ul>
            </article>
        </div>
        <p class="service-note">Every space is different. Contact us for a tailored plan and a free quote.</p>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
