
<?php
session_start();
require_once __DIR__ . "/config/koneksi.php";
require_once __DIR__ . "/config/lang.php";

$error = "";

if (($_SESSION["login"] ?? false) === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, username, password, nama, role
         FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["login"] = true;
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["nama"] = $user["nama"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit;
    }

    $error = "Username atau password salah.";
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($_SESSION["lang"]) ?>">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars(t("login")) ?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>


<main class="login-container">

    <div class="card login-card">

        <div class="login-header">
            <h1><?= htmlspecialchars(t("welcome")) ?></h1>
            <p><?= htmlspecialchars(t("title")) ?></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>
		
		 <form method="POST">

            <label><?= htmlspecialchars(t("username")) ?></label>
            <input
                type="text"
                name="username"
                placeholder="<?= htmlspecialchars(t("username")) ?>"
                required
            >

            <label><?= htmlspecialchars(t("password")) ?></label>
            <input
                type="password"
                name="password"
                placeholder="<?= htmlspecialchars(t("password")) ?>"
                required
            >

            <button type="submit">
                <?= htmlspecialchars(t("login")) ?>
            </button>

        </form>

    </div>

</main>

<p>
    <a href="set_lang.php?lang=id">Indonesia</a> |
    <a href="set_lang.php?lang=en">English</a>
</p>

</body>
</html>
