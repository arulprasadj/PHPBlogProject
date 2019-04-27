<!DOCTYPE html>
<html>
    <head>
        <title><?= (!empty($headerArgs['Title']))? $headerArgs['Title'] : '' ?></title>
        <meta charset="UTF-8">
        <meta name="description" content="<?= (!empty($headerArgs['Description']))? $headerArgs['Description'] : '' ?>">
        <meta name="keywords" content="<?= (!empty($headerArgs['Keywords']))? $headerArgs['Keywords'] : '' ?>">
        <meta name="author" content="Jack Vincent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="_styles/styles.css">
    </head>
    <body>