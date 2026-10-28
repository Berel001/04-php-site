<?php
declare(strict_types=1);

session_start();

$pageTitle = 'Messages';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

if (!isset($_SESSION['messages_csrf_token']) || !is_string($_SESSION['messages_csrf_token'])) {
    $_SESSION['messages_csrf_token'] = bin2hex(random_bytes(32));
}

$loginError = '';
$isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$isAuthenticated) {
    $submittedToken = $_POST['csrf_token'] ?? '';
    $submittedPassword = $_POST['password'] ?? '';

    if (
        !is_string($submittedToken)
        || !hash_equals($_SESSION['messages_csrf_token'], $submittedToken)
    ) {
        $loginError = 'Your form session has expired. Please reload and try again.';
    } elseif (
        !is_string($submittedPassword)
        || !hash_equals($messagesPassword, $submittedPassword)
    ) {
        $loginError = 'That password was not correct. Please try again.';
    } else {
        session_regenerate_id(true);
        $_SESSION['messages_authenticated'] = true;
        header('Location: messages.php', true, 303);
        exit;
    }
}

$messages = [];
$readError = '';

if ($isAuthenticated) {
    $messagesFile = __DIR__ . '/storage/messages.jsonl';

    if (is_file($messagesFile)) {
        $contents = file_get_contents($messagesFile);

        if ($contents === false) {
            error_log('Messages page could not read storage/messages.jsonl.');
            $readError = 'Messages could not be read. Check the storage file permissions.';
        } else {
            foreach (explode("\n", $contents) as $lineNumber => $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                try {
                    $record = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $exception) {
                    error_log('Messages page found invalid JSON on line ' . ($lineNumber + 1) . '.');
                    $readError = 'Some stored messages could not be displayed because the message file contains invalid data.';
                    continue;
                }

                if (
                    !is_array($record)
                    || !is_string($record['timestamp'] ?? null)
                    || !is_string($record['name'] ?? null)
                    || !is_string($record['email'] ?? null)
                    || !is_string($record['phone'] ?? null)
                    || !is_string($record['service'] ?? null)
                    || !is_string($record['message'] ?? null)
                ) {
                    error_log('Messages page found an incomplete record on line ' . ($lineNumber + 1) . '.');
                    $readError = 'Some stored messages could not be displayed because the message file contains incomplete data.';
                    continue;
                }

                $record['sort_timestamp'] = strtotime($record['timestamp']) ?: 0;
                $messages[] = $record;
            }

            usort(
                $messages,
                static fn (array $first, array $second): int => $second['sort_timestamp'] <=> $first['sort_timestamp']
            );
        }
    } elseif (file_exists($messagesFile)) {
        error_log('Messages page storage/messages.jsonl exists but is not a regular file.');
        $readError = 'Messages could not be read. The storage path is not a regular file.';
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<main>
    <section class="page-banner">
        <div class="container">
            <p class="eyebrow">Local learning inbox</p>
            <h1>Contact messages</h1>
            <p>Review submissions received through the contact form.</p>
        </div>
    </section>

    <section class="section container">
        <?php if (!$isAuthenticated): ?>
            <div class="messages-login contact-card">
                <p class="eyebrow">Restricted page</p>
                <h2>Enter the local inbox password</h2>
                <?php if ($loginError !== ''): ?>
                    <p class="form-alert form-alert-error" role="alert"><?= e($loginError) ?></p>
                <?php endif; ?>
                <form class="contact-form" method="post" action="messages.php">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['messages_csrf_token']) ?>">
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="button" type="submit">View messages</button>
                </form>
            </div>
        <?php else: ?>
            <div class="messages-heading">
                <h2>Submissions</h2>
                <span class="count-badge"><?= count($messages) ?> <?= count($messages) === 1 ? 'message' : 'messages' ?></span>
            </div>

            <?php if ($readError !== ''): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($readError) ?></p>
            <?php endif; ?>

            <?php if ($messages === []): ?>
                <p class="messages-empty">There are no messages to display yet.</p>
            <?php else: ?>
                <div class="messages-table-wrap">
                    <table class="messages-table">
                        <thead>
                            <tr>
                                <th scope="col">Received</th>
                                <th scope="col">Name &amp; contact</th>
                                <th scope="col">Service</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= e($message['timestamp']) ?></td>
                                    <td>
                                        <strong><?= e($message['name']) ?></strong><br>
                                        <a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>
                                        <?php if ($message['phone'] !== ''): ?>
                                            <br><?= e($message['phone']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= e($message['service']) ?></td>
                                    <td class="message-cell"><?= e($message['message']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
