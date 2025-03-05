<!DOCTYPE html>
<html lang="<?php echo $_ENV['APP_LOCALE'] ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_ENV['APP_NAME'] . " - " . ($this->data['title_head'] ?? ""); ?></title>

    <link rel="stylesheet" href="<?php echo $_ENV['URL_ADM'] ?>public/adms/css/sbadmin.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

