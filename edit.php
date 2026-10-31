<?php
require_once __DIR__ . "/auth/auth.php";
require_once __DIR__ . "/config/koneksi.php";
require_once __DIR__ . "/config/lang.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$mahasiswa = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$mahasiswa) {
    header("Location: index.php");
    exit;
}
$nim = $mahasiswa["nim"];
$nama = $mahasiswa["nama"];
$jurusan = $mahasiswa["jurusan"];
$angkatan = $mahasiswa["angkatan"];
$email = $mahasiswa["email"];

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jurusan = trim($_POST["jurusan"] ?? "");
    $angkatan = trim($_POST["angkatan"] ?? "");
    $email = trim($_POST["email"] ?? "");

    
    if ($nim === "" || $nama === "" || $jurusan === "" || $angkatan === "") {
        $errors[] = "NIM, nama, jurusan, dan angkatan wajib diisi.";
    }

    if ($nim !== "" && !ctype_digit($nim)) {
        $errors[] = "NIM harus berupa angka.";
    }

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    if (
        $angkatan !== "" &&
        (!ctype_digit($angkatan) || (int)$angkatan < 1901 || (int)$angkatan > 2155)
    ) {
        $errors[] = "Angkatan harus berupa tahun yang valid.";
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE mahasiswa
             SET nim = ?, nama = ?, jurusan = ?, angkatan = ?, email = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssisi",
            $nim,
            $nama,
            $jurusan,
            $angkatan,
            $email,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit;
        } else {
            if (mysqli_errno($koneksi) === 1062) {
                $errors[] = "NIM sudah terdaftar.";
            } else {
                $errors[] = "Gagal memperbarui data mahasiswa.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}

require_once __DIR__ . "/auth/header.php";

?>

<main>
	<div class="card">
		<h2><?= htmlspecialchars(t("edit_title")) ?></h2>

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
			<label><?= htmlspecialchars(t("label_nim")) ?></label>
			<input
				type="text"
				name="nim"
				value="<?= htmlspecialchars($nim, ENT_QUOTES, "UTF-8") ?>"
				maxlength="20"
				required
			><br><br>

			<label><?= htmlspecialchars(t("label_name")) ?></label>
			<input
				type="text"
				name="nama"
				value="<?= htmlspecialchars($nama, ENT_QUOTES, "UTF-8") ?>"
				required
			><br><br>

			<label><?= htmlspecialchars(t("label_major")) ?></label>
			<input
				type="text"
				name="jurusan"
				value="<?= htmlspecialchars($jurusan, ENT_QUOTES, "UTF-8") ?>"
				required
			><br><br>

			<label><?= htmlspecialchars(t("label_year")) ?></label>
			<input
				type="number"
				name="angkatan"
				value="<?= htmlspecialchars((string)$angkatan, ENT_QUOTES, "UTF-8") ?>"
				min="1901"
				max="2155"
				required
			><br><br>

			<label><?= htmlspecialchars(t("label_email")) ?></label>
			<input
				type="email"
				name="email"
				value="<?= htmlspecialchars($email ?? "", ENT_QUOTES, "UTF-8") ?>"
			><br><br>

			<button type="submit"><?= htmlspecialchars(t("update")) ?></button>
			<a href="index.php" class="btn"><?= htmlspecialchars(t("cancel")) ?></a>
		</form>
	</div>
</body>
</html>