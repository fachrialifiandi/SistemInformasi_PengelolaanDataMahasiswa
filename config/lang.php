
<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "id";
}

$text = [
    "id" => [
        "title" => "Sistem Informasi Mahasiswa",
        "welcome" => "Selamat Datang",
        "dashboard" => "Dashboard",
        "student" => "Data Mahasiswa",
        "username" => "Nama Pengguna",
        "password" => "Kata Sandi",
        "login" => "Masuk",
        "logout" => "Keluar",
        "language" => "Bahasa",
		"lable_add" => "Tambah data mahasiswa",
		"add_title" => "Tambah Data Mahasiswa",
		"edit_title" => "Edit Data Mahasiswa",
		"required_error" => "NIM, nama, jurusan, dan angkatan wajib diisi.",
		"nim_number_error" => "NIM harus berupa angka.",
		"nim_length_error" => "NIM maksimal 20 karakter.",
		"email_error" => "Format email tidak valid.",
		"year_error" => "Angkatan harus berupa tahun yang valid.",
		"nim_exists_error" => "NIM sudah terdaftar.",
		"update_error" => "Gagal memperbarui data mahasiswa.",
		"label_nim" => "NIM",
		"label_name" => "Nama",
		"label_major" => "Jurusan",
		"label_year" => "Angkatan",
		"label_email" => "Email",
		"save" => "Simpan",
		"update" => "Perbarui",
		"cancel" => "Batal",
		"delete_confirm" => "Apakah Anda yakin ingin menghapus data mahasiswa ini?",
    ],

    "en" => [
        "title" => "Student Information System",
        "welcome" => "Welcome",
        "dashboard" => "Dashboard",
        "student" => "Student Data",
        "username" => "Username",
        "password" => "Password",
        "login" => "Login",
        "logout" => "Logout",
        "language" => "Language",
		"lable_add" => "Add Student",
		"add_title" => "Add Student Data",
		"edit_title" => "Edit Student Data",
		"required_error" => "NIM, name, major, and year are required.",
		"nim_number_error" => "NIM must contain only numbers.",
		"nim_length_error" => "NIM must not exceed 20 characters.",
		"email_error" => "Invalid email format.",
		"year_error" => "Year must be valid.",
		"nim_exists_error" => "NIM is already registered.",
		"update_error" => "Failed to update student data.",
		"label_nim" => "NIM",
		"label_name" => "Name",
		"label_major" => "Major",
		"label_year" => "Year",
		"label_email" => "Email",
		"save" => "Save",
		"update" => "Update",
		"cancel" => "Cancel",
		"delete_confirm" => "Are you sure you want to delete this student data?",
	],
];

function t($key)
{
    global $text;

    $lang = $_SESSION["lang"] ?? "id";

    return $text[$lang][$key]
        ?? $text["id"][$key]
        ?? $key;
}
?>
