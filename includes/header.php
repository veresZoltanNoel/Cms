<!DOCTYPE html>
<html>
<head>
    <title>My blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link   href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
            crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
    <header>
        <h1>My blog</h1>
    </header>
    <nav>
        <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
            <?php if (Auth::isLoggedIn()) : ?>
                <li class="nav-item"><a class="nav-link" href="/admin">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="/logout.php">Log out</a></li>

            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/login.php">Log in</a></li>

            <?php endif; ?>
        </ul>
    </nav>
    <main>
