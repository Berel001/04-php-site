<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $amount): string
{
    return '₦' . number_format($amount, 2);
}

function renderServiceCard(array $service): string
{
    $slug = e(rawurlencode($service['slug']));
    $icon = e($service['icon']);
    $title = e($service['title']);
    $description = e($service['description']);
    $price = e(formatPrice($service['price']));

    return <<<HTML
        <article class="service-card">
            <span class="service-icon" aria-hidden="true">{$icon}</span>
            <h2>{$title}</h2>
            <p>{$description}</p>
            <p class="service-price">From {$price}</p>
            <a class="service-link" href="service.php?slug={$slug}">View service details</a>
        </article>
        HTML;
}
