<?php

require_once __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;

// Read data file
$dataFile = __DIR__ . '/data.txt';

if (file_exists($dataFile)) {
    $dataContent  = htmlspecialchars(file_get_contents($dataFile), ENT_QUOTES, 'UTF-8');
    $dataModified = Carbon::createFromTimestamp(filemtime($dataFile));
    $dataModifiedHuman = $dataModified->diffForHumans();
    $dataModifiedFull  = $dataModified->toDateTimeString();
} else {
    $dataContent       = '(data.txt not found)';
    $dataModifiedHuman = 'N/A';
    $dataModifiedFull  = 'N/A';
}

$builtAt   = file_exists(__DIR__ . '/public/mix-manifest.json')
    ? Carbon::createFromTimestamp(filemtime(__DIR__ . '/public/mix-manifest.json'))->toDayDateTimeString()
    : 'not built';

$phpVersion    = PHP_VERSION;
$carbonVersion = \Composer\InstalledVersions::getPrettyVersion('nesbot/carbon');
$now           = Carbon::now()->toDateTimeString();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Git Deploy Test Site</title>
    <link rel="stylesheet" href="public/css/app.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <span class="header-badge">deploy</span>
            <h1>Git Deployment Test Site</h1>
            <span class="header-sub"><?= $now ?></span>
        </div>
    </header>

    <main class="site-main">

        <!-- Environment info -->
        <div class="card">
            <div class="card-header">
                <h2>Environment</h2>
                <span class="card-meta"><span class="status-dot"></span>running</span>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>PHP Version</label>
                        <span class="value value--mono"><?= htmlspecialchars($phpVersion, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Carbon Version</label>
                        <span class="value value--mono"><?= htmlspecialchars($carbonVersion, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Assets Built</label>
                        <span class="value value--accent"><?= htmlspecialchars($builtAt, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Server Time</label>
                        <span class="value value--mono"><?= htmlspecialchars($now, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data file content -->
        <div class="card">
            <div class="card-header">
                <h2>data.txt</h2>
                <span class="card-meta">modified <?= htmlspecialchars($dataModifiedHuman, ENT_QUOTES, 'UTF-8') ?> &mdash; <?= htmlspecialchars($dataModifiedFull, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="card-body">
                <pre class="data-content"><?= $dataContent ?></pre>
            </div>
        </div>

    </main>

    <footer class="site-footer">
        Rendered by PHP <?= htmlspecialchars($phpVersion, ENT_QUOTES, 'UTF-8') ?> &middot; Styles compiled by Laravel Mix &middot; Carbon <?= htmlspecialchars($carbonVersion, ENT_QUOTES, 'UTF-8') ?>
    </footer>

</body>
</html>
