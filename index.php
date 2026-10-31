<?php
require_once __DIR__ . "/auth/auth.php";
require_once __DIR__ . "/config/koneksi.php";
require_once __DIR__ . "/auth/header.php";

$query = "SELECT * FROM mahasiswa ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Gagal mengambil data mahasiswa.");
}
?>
<main>
	
	<div class="card">
		<h1><?= htmlspecialchars(t("dashboard")) ?></h1>
		<h1><?= htmlspecialchars(t("student")) ?></h1>

	<p>
		<?= htmlspecialchars(t("welcome")) ?>,
		<?= htmlspecialchars($_SESSION["nama"]) ?>!
	</p>

	<p>
		<a href="tambah.php" class="btn">
			+ <?= htmlspecialchars(t("lable_add")) ?>
		</a>
	</p>

	<table border="1" cellpadding="8" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th><?= htmlspecialchars(t("nim")) ?></th>
				<th><?= htmlspecialchars(t("name")) ?></th>
				<th><?= htmlspecialchars(t("major")) ?></th>
				<th><?= htmlspecialchars(t("year")) ?></th>
				<th><?= htmlspecialchars(t("email")) ?></th>
				<th><?= htmlspecialchars(t("action")) ?></th>
			</tr>
		</thead>

		<tbody>
			<?php if (mysqli_num_rows($result) > 0): ?>
				<?php $no = 1; ?>

				<?php while ($row = mysqli_fetch_assoc($result)): ?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= htmlspecialchars($row["nim"]) ?></td>
						<td><?= htmlspecialchars($row["nama"]) ?></td>
						<td><?= htmlspecialchars($row["jurusan"]) ?></td>
						<td><?= htmlspecialchars((string) $row["angkatan"]) ?></td>
						<td><?= htmlspecialchars($row["email"] ?? "") ?></td>
						<td>
							<a href="edit.php?id=<?= (int) $row["id"] ?>">
								<?= htmlspecialchars(t("edit")) ?>
							</a>
							|
							<a
								href="hapus.php?id=<?= (int) $row["id"] ?>"
								onclick="return confirm('<?= htmlspecialchars(t("delete_confirm"), ENT_QUOTES, "UTF-8") ?>')"
							>
								<?= htmlspecialchars(t("delete")) ?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>

			<?php else: ?>
				<tr>
					<td colspan="7">
						<?= htmlspecialchars(t("no_data")) ?>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
		</div>
<main>
</body>
</html>
