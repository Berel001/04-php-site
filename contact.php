<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
$formValues = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'service' => '',
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (array_keys($formValues) as $field) {
        $value = $_POST[$field] ?? '';

        if (!is_string($value)) {
            $errors[$field] = 'Please enter a valid value.';
            continue;
        }

        $formValues[$field] = trim($value);
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (
        !is_string($submittedToken)
        || !hash_equals($_SESSION['csrf_token'], $submittedToken)
    ) {
        $errors['_csrf'] = 'Your form session has expired. Please check the form and try again.';
    }

    if ($formValues['name'] === '') {
        $errors['name'] = 'Please enter your name.';
    }

    if ($formValues['email'] === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (filter_var($formValues['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($formValues['service'] === '') {
        $errors['service'] = 'Please choose a service.';
    } else {
        $validServiceSlugs = array_column($services, 'slug');
        if (!in_array($formValues['service'], $validServiceSlugs, true)) {
            $errors['service'] = 'Please choose one of the listed services.';
        }
    }

    if ($formValues['message'] === '') {
        $errors['message'] = 'Please enter a message.';
    } else {
        $messageLength = mb_strlen($formValues['message'], 'UTF-8');
        if ($messageLength < 10 || $messageLength > 1000) {
            $errors['message'] = 'Your message must be between 10 and 1000 characters.';
        }
    }

    if ($errors === []) {
        $storageDirectory = __DIR__ . '/storage';

        if (
            !is_dir($storageDirectory)
            && !mkdir($storageDirectory, 0775, true)
            && !is_dir($storageDirectory)
        ) {
            error_log('Contact form could not create the message storage directory.');
            $errors['_form'] = 'We could not save your message just now. Please try again later.';
        } else {
            $submission = [
                'timestamp' => date(DATE_ATOM),
                'name' => $formValues['name'],
                'email' => $formValues['email'],
                'phone' => $formValues['phone'],
                'service' => $formValues['service'],
                'message' => $formValues['message'],
            ];

            try {
                $jsonLine = json_encode($submission, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
                $bytesWritten = file_put_contents(
                    $storageDirectory . '/messages.jsonl',
                    $jsonLine . PHP_EOL,
                    FILE_APPEND | LOCK_EX
                );

                if ($bytesWritten === false) {
                    error_log('Contact form could not append a message to the storage file.');
                    $errors['_form'] = 'We could not save your message just now. Please try again later.';
                } else {
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    header('Location: contact.php?sent=1', true, 303);
                    exit;
                }
            } catch (JsonException $exception) {
                error_log('Contact form JSON encoding failed: ' . $exception->getMessage());
                $errors['_form'] = 'We could not save your message just now. Please try again later.';
            }
        }
    }
}

$messageSent = ($_GET['sent'] ?? '') === '1';
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
            <p class="eyebrow">Send us a message</p>
            <h2>We’d love to hear from you.</h2>
            <p>Tell us what you need and we’ll get back to you as soon as we can.</p>

            <?php if ($messageSent): ?>
                <p class="form-alert form-alert-success" role="status">
                    Thanks for getting in touch. Your message has been received.
                </p>
            <?php endif; ?>

            <?php if (isset($errors['_form'])): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($errors['_form']) ?></p>
            <?php endif; ?>

            <?php if (isset($errors['_csrf'])): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($errors['_csrf']) ?></p>
            <?php endif; ?>

            <form class="contact-form" method="post" action="contact.php" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                <div class="form-field">
                    <label for="name">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        autocomplete="name"
                        required
                        value="<?= e($formValues['name']) ?>"
                        <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="name-error"' : '' ?>
                    >
                    <?php if (isset($errors['name'])): ?>
                        <p class="field-error" id="name-error"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="<?= e($formValues['email']) ?>"
                        <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>
                    >
                    <?php if (isset($errors['email'])): ?>
                        <p class="field-error" id="email-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="phone">Phone <span class="optional">(optional)</span></label>
                    <input
                        id="phone"
                        name="phone"
                        type="tel"
                        autocomplete="tel"
                        value="<?= e($formValues['phone']) ?>"
                        <?= isset($errors['phone']) ? 'aria-invalid="true" aria-describedby="phone-error"' : '' ?>
                    >
                    <?php if (isset($errors['phone'])): ?>
                        <p class="field-error" id="phone-error"><?= e($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="service">Service</label>
                    <select
                        id="service"
                        name="service"
                        required
                        <?= isset($errors['service']) ? 'aria-invalid="true" aria-describedby="service-error"' : '' ?>
                    >
                        <option value="">Choose a service</option>
                        <?php foreach ($services as $service): ?>
                            <option
                                value="<?= e($service['slug']) ?>"
                                <?= $formValues['service'] === $service['slug'] ? 'selected' : '' ?>
                            ><?= e($service['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['service'])): ?>
                        <p class="field-error" id="service-error"><?= e($errors['service']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="message">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        <?= isset($errors['message']) ? 'aria-invalid="true" aria-describedby="message-error"' : '' ?>
                    ><?= e($formValues['message']) ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <p class="field-error" id="message-error"><?= e($errors['message']) ?></p>
                    <?php endif; ?>
                    <p class="field-hint">Please use 10 to 1000 characters.</p>
                </div>

                <button class="button" type="submit">Send message</button>
            </form>

            <p class="contact-direct">Prefer email? <a href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a></p>
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
