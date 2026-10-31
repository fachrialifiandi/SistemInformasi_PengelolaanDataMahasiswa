<?php
require_once __DIR__ . "/auth/auth.php";
require_once __DIR__ . "/config/koneksi.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare(
		$koneksi,
		"DELETE FROM mahasiswa where id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$affected_rows = mysqli_stmt_affected_rows($stmt);

mysqli_stmt_close($stmt);

header("Location: index.php");
exit;


?>