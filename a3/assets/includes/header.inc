
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle ?? "Books - BookVerse", ENT_QUOTES, "UTF-8"); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="./assets/css/style.css?v=<?php echo filemtime(__DIR__ . '/../css/style.css'); ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer
        src="./assets/js/scripts.js?v=<?php echo filemtime(__DIR__ . '/../js/scripts.js'); ?>"></script>
</head>
