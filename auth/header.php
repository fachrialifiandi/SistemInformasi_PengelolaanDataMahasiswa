<?php
require_once __DIR__ . "/../config/lang.php";
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($_SESSION["lang"]) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t("title")) ?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php"><?= htmlspecialchars(t("dashboard")) ?></a>
    |
    <a href="logout.php"><?= htmlspecialchars(t("logout")) ?></a>
    |
    <?= htmlspecialchars(t("language")) ?>:
    <a href="set_lang.php?lang=id">Indonesia</a>
    /
    <a href="set_lang.php?lang=en">English</a>
</nav>

<hr>
