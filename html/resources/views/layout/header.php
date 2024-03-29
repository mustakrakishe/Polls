<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? '' ?></title>

    <link rel="stylesheet" href="<?= join(DIRECTORY_SEPARATOR, [
        'resources',
        'css',
        'bootstrap.min.css'
    ]); ?>">
</head>

<body>
    <div class="container py-3">
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
                    <span class="fs-4">Polls</span>
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                    <?php if (isset($parameters['user'])): ?>
                        <div class="me-3 py-2"><?= $parameters['user']['email'] ?></div>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/logout">Logout</a>
                    <?php else: ?>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/login">Login</a>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/register">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main>