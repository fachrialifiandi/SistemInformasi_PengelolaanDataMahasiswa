<?php
session_start();

if (isset($_GET["lang"]) &&
    in_array($_GET["lang"], ["id", "en"], true)) {
    $_SESSION["lang"] = $_GET["lang"];
}

$back = $_SERVER["HTTP_REFERER"] ?? "index.php";
$target = parse_url($back);

if (
    isset($target["host"]) &&
    strtolower($target["host"]) !==
    strtolower($_SERVER["HTTP_HOST"])
) {
    $back = "index.php";
}

header("Location: " . $back);
exit;
?>
