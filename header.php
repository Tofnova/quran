<?php
// প্রতিটা পেজ include করার আগে এই ভ্যারিয়েবলগুলো সেট করতে পারে: $page, $title, $desc
$page  = $page  ?? 'home';
$title = $title ?? 'কুরআন API ও বাংলা অনুবাদ';
$desc  = $desc  ?? 'আরবি ও বাংলা অনুবাদসহ কুরআনের ৬২৩৬টি আয়াতের ফ্রি JSON API এবং আয়াতের ছবি বানানোর টুল।';
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$base   = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$h = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $h($title) ?></title>
    <meta name="description" content="<?= $h($desc) ?>">
    <meta name="theme-color" content="#1b6b4a">

    <!-- আইকন -->
    <link rel="icon" href="/asset/quran.png" type="image/png">
    <link rel="shortcut icon" href="/asset/quran.png" type="image/png">
    <link rel="apple-touch-icon" href="/asset/quran.png">

    <!-- শেয়ার করলে যা দেখাবে -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="bn_BD">
    <meta property="og:title" content="<?= $h($title) ?>">
    <meta property="og:description" content="<?= $h($desc) ?>">
    <meta property="og:image" content="<?= $h($base) ?>/asset/quran.png">

    <link rel="stylesheet" href="/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Scheherazade+New:wght@400;700&family=Noto+Naskh+Arabic:wght@400;700&family=Noto+Serif+Bengali:wght@400;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Tiro+Bangla&family=Cinzel:wght@600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <nav class="flex medel around">
        <a href="/" class="nav-logo flex medel w10">
            <img src="/asset/quran.png" alt="কুরআন API লোগো">
            <h2>আল কুরআন</h2>
        </a>
        <div>
            <?php if ($page === 'docs'): ?>
                <a class="nav-btn" href="/"><i class="fa-solid fa-house"></i>হোম</a>
            <?php else: ?>
                <a class="nav-btn" href="/docs"><i class="fa-solid fa-code"></i>API ডকস</a>
            <?php endif; ?>
             <a class="nav-btn" href="https://github.com/Tofnova/quran"><i class="fa-brands fa-github"></i></a>
        </div>
    </nav>
    <br><br><br><br><br>
