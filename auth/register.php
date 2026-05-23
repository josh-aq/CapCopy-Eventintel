<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('/html/signup.php');
}

$first = trim($_POST['first_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$mi = trim($_POST['middle_initial'] ?? '');
$username = trim($_POST['username'] ?? ($_POST['email'] ?? ''));
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? $password;
$role = 'client';

$full = trim($first . ' ' . $mi . ' ' . $last);
if ($full === '') $full = $username;
$status = 'approved';

$age = ($_POST['age'] ?? '') !== '' ? intval($_POST['age']) : null;
$gender = trim($_POST['gender'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$province = trim($_POST['province'] ?? '');
$municipality = trim($_POST['municipality'] ?? '');
$barangay = trim($_POST['barangay'] ?? '');
$postal_code = trim($_POST['postal_code'] ?? '');
$business = trim($_POST['business_name'] ?? '');
$address = trim($_POST['business_address'] ?? '');

function save_upload($field, $folder) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['jpg','jpeg','png','webp','pdf'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) return null;
    $dir = __DIR__ . '/../uploads/' . $folder;
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $name = $folder . '/' . uniqid($field . '_', true) . '.' . $ext;
    $dest = __DIR__ . '/../uploads/' . $name;
    move_uploaded_file($_FILES[$field]['tmp_name'], $dest);
    return 'uploads/' . $name;
}

$valid_id = save_upload('valid_id', 'ids');
$permit = save_upload('business_permit', 'permits');

$face_path = null;
$face_data = $_POST['face_capture'] ?? '';
if (str_starts_with($face_data, 'data:image')) {
    $face_data = preg_replace('#^data:image/\w+;base64,#i', '', $face_data);
    $face_raw = base64_decode($face_data);
    if ($face_raw) {
        $dir = __DIR__ . '/../uploads/faces';
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $face_name = 'faces/face_' . uniqid('', true) . '.png';
        file_put_contents(__DIR__ . '/../uploads/' . $face_name, $face_raw);
        $face_path = 'uploads/' . $face_name;
    }
}

if ($username === '' || $email === '' || $password === '' || $password !== $confirm) {
    redirect_to('/html/signup.php?error=missing');
}

try {
    $stmt = db()->prepare("INSERT INTO users (
        username, full_name, email, password, role, status,
        first_name, last_name, middle_initial, age, gender, phone,
        province, municipality, barangay, postal_code,
        business_name, business_address, valid_id, business_permit, face_capture
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $username, $full, $email, password_hash($password, PASSWORD_DEFAULT), $role, $status,
        $first, $last, $mi, $age, $gender, $phone,
        $province, $municipality, $barangay, $postal_code,
        $business, $address, $valid_id, $permit, $face_path
    ]);
} catch (Exception $e) {
    redirect_to('/html/signup.php?error=exists');
}

if ($role === 'client') redirect_to('/html/index.php?registered=1');
redirect_to('/html/index.php?pending=1');
?>
