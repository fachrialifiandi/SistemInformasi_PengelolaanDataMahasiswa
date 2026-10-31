<?php
require_once __DIR__ . "/auth/auth.php";
require_once __DIR__ . "/config/koneksi.php";
require_once __DIR__ . "/config/lang.php";

$errors = [];
$nim = "";
$nama = "";
$jurusan = "";
$angkatan = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jurusan = trim($_POST["jurusan"] ?? "");
    $angkatan = trim($_POST["angkatan"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (
        $nim === "" ||
        $nama === "" ||
        $jurusan === "" ||
        $angkatan === ""
    ) {
        $errors[] = t("required_error");
    }

    if ($nim !== "" && !ctype_digit($nim)) {
        $errors[] = t("nim_number_error");
    }


    if (
        $email !== "" &&
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $errors[] = t("email_error");
    }

    if (
        $angkatan !== "" &&
        (
            !ctype_digit($angkatan) ||
            (int)$angkatan < 1901 ||
            (int)$angkatan > 2155
        )
    ) {
         $errors[] = t("year_error");
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO mahasiswa
            (nim, nama, jurusan, angkatan, email)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssis",
            $nim,
            $nama,
            $jurusan,
            $angkatan,
            $email
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit;
        } else {
            if (mysqli_stmt_errno($stmt) === 1062) {
                $errors[] = "NIM sudah terdaftar.";
            } else {
                $errors[] = "Gagal menyimpan data mahasiswa.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($_SESSION["lang"] ?? "id") ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
</head>
<body>

<?php require_once __DIR__ . "/auth/header.php"; ?>

<main>
	<div class="card">

		<h2><?= htmlspecialchars(t("add_title")) ?></h2>
		<?php if (!empty($errors)): ?>
			<div class="error">
				<ul>
					<?php foreach ($errors as $error): ?>
						<li>
							<?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<form method="POST">
			<label><?= htmlspecialchars(t("label_nim")) ?></label><br>
			<input type="text" name="nim"
				value="<?= htmlspecialchars($nim, ENT_QUOTES, "UTF-8") ?>"
				maxlength="20" required>
			<br><br>

			<label><?= htmlspecialchars(t("label_name")) ?></label><br>
			<input type="text" name="nama"
				value="<?= htmlspecialchars($nama, ENT_QUOTES, "UTF-8") ?>"
				required>
			<br><br>

			<label><?= htmlspecialchars(t("label_major")) ?></label><br>
			<input type="text" name="jurusan"
				value="<?= htmlspecialchars($jurusan, ENT_QUOTES, "UTF-8") ?>"
				required>
			<br><br>

			<label><?= htmlspecialchars(t("label_year")) ?></label><br>
			<input type="number" name="angkatan"
				value="<?= htmlspecialchars($angkatan, ENT_QUOTES, "UTF-8") ?>"
				required>
			<br><br>

			<label><?= htmlspecialchars(t("label_email")) ?></label><br>
			<input type="email" name="email"
				value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>">
			<br><br>

			<button type="submit"><?= htmlspecialchars(t("save")) ?></button>
			<a href="index.php" class="btn"><?= htmlspecialchars(t("cancel")) ?></a>
		</form>
	</div>
</main>
</body>
</html>
