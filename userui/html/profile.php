<?php
require_once __DIR__ . '/../../config/db.php';
require_login();
$pdo = db();
$userId = $_SESSION['user_id'];
$message = '';
$messageType = 'info';

$save_upload = function ($field, $folder) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return null;
    }
    $dir = __DIR__ . '/../../uploads/' . $folder;
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $name = $folder . '/' . uniqid($field . '_', true) . '.' . $ext;
    $dest = __DIR__ . '/../../uploads/' . $name;
    move_uploaded_file($_FILES[$field]['tmp_name'], $dest);
    return 'uploads/' . $name;
};

$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();
if (!$currentUser) {
    redirect_to('/html/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_role'])) {
    $applyRole = $_POST['apply_role'] === 'supplier' ? 'supplier' : 'coordinator';
    $businessName = trim($_POST['business_name'] ?? '');
    $businessAddress = trim($_POST['business_address'] ?? '');

    if ($businessName === '' || $businessAddress === '') {
        $message = 'Please fill in the business name and address.';
        $messageType = 'error';
    } else {
        $validId = $save_upload('valid_id', 'ids') ?? $currentUser['valid_id'];
        $permit = $save_upload('business_permit', 'permits') ?? $currentUser['business_permit'];

        $facePath = $currentUser['face_capture'];
        $faceData = $_POST['face_capture'] ?? '';
        if (is_string($faceData) && str_starts_with($faceData, 'data:image')) {
            $faceData = preg_replace('#^data:image/\w+;base64,#i', '', $faceData);
            $faceRaw = base64_decode($faceData);
            if ($faceRaw) {
                $faceDir = __DIR__ . '/../../uploads/faces';
                if (!is_dir($faceDir)) mkdir($faceDir, 0777, true);
                $faceName = 'faces/face_' . uniqid('', true) . '.png';
                file_put_contents(__DIR__ . '/../../uploads/' . $faceName, $faceRaw);
                $facePath = 'uploads/' . $faceName;
            }
        }

        $update = $pdo->prepare('UPDATE users SET role = ?, status = ?, business_name = ?, business_address = ?, valid_id = ?, business_permit = ?, face_capture = ? WHERE user_id = ?');
        $update->execute([
            $applyRole,
            'pending',
            $businessName,
            $businessAddress,
            $validId,
            $permit,
            $facePath,
            $userId,
        ]);

        $_SESSION['role'] = $applyRole;
        $_SESSION['status'] = 'pending';
        $currentUser['role'] = $applyRole;
        $currentUser['status'] = 'pending';
        $currentUser['business_name'] = $businessName;
        $currentUser['business_address'] = $businessAddress;
        $currentUser['valid_id'] = $validId;
        $currentUser['business_permit'] = $permit;
        $currentUser['face_capture'] = $facePath;

        $message = 'Application submitted as ' . ucfirst($applyRole) . '. Admin will review it shortly.';
        $messageType = 'success';
    }
}

$displayRole = $currentUser['role'] === 'client' ? 'Client' : ucfirst($currentUser['role']);
$displayStatus = ucfirst($currentUser['status'] ?? 'approved');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body{background:#050505;color:white;font-family:Segoe UI;padding:40px}
        .card{background:#111;border:1px solid rgba(255,215,0,.25);border-radius:20px;padding:25px;max-width:980px;margin:0 auto;}
        a{color:#f3c547}
        .logout-btn{display:inline-block;margin-top:15px;padding:12px 24px;background:rgba(255,80,80,.15);border:1px solid rgba(255,80,80,.3);color:#ff8b8b;border-radius:12px;text-decoration:none;font-weight:700;transition:.3s}
        .logout-btn:hover{background:rgba(255,80,80,.25);transform:translateY(-2px)}
        .button{appearance:none;border:none;border-radius:14px;padding:14px 20px;margin-right:10px;background:linear-gradient(135deg,#fff1a8,#f3c547 48%,#c98f08);color:#111;font-weight:800;cursor:pointer;transition:.3s}
        .button:hover{transform:translateY(-2px)}
        .info-box{margin:18px 0;padding:18px;border-radius:18px;background:rgba(243,197,71,.08);border:1px solid rgba(243,197,71,.18);color:#fff}
        .success{background:rgba(67,181,129,.18);border:1px solid rgba(67,181,129,.35);color:#b1f3be;margin:20px 0;padding:16px;border-radius:16px;}
        .error{background:rgba(255,80,80,.14);border:1px solid rgba(255,80,80,.32);color:#ffb3b3;margin:20px 0;padding:16px;border-radius:16px;}
        .application-panel{margin-top:24px;padding:24px;border-radius:24px;border:1px solid rgba(243,197,71,.18);background:rgba(255,255,255,.02)}
        .application-panel label{display:block;margin:16px 0 8px;color:#ccc;font-size:14px}
        .application-panel input[type=text],.application-panel input[type=file]{width:100%;padding:14px 16px;border-radius:16px;border:1px solid rgba(255,255,255,.08);background:#090909;color:#fff;outline:none}
        .application-panel .button{margin-top:16px}
        .video-card{margin-top:18px;border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,.08);background:#111;}
        .video-card video{width:100%;height:auto;display:block}
        .status-pill{display:inline-flex;padding:8px 14px;border-radius:999px;background:rgba(243,197,71,.12);color:#f3c547;font-weight:700;margin-top:14px}
    </style>
</head>
<body>
    <a href="homepage.php">← Home</a>
    <div class="card">
        <h1><?= esc($currentUser['full_name'] ?? $currentUser['username']) ?></h1>
        <p>Role: <?= esc($displayRole) ?> | Status: <span class="status-pill"><?= esc($displayStatus) ?></span></p>
        <p>Username: <?= esc($currentUser['username']) ?></p>
        <?php if ($currentUser['business_name'] || $currentUser['business_address']): ?>
            <div class="info-box" style="background:rgba(255,255,255,.04);border-color:rgba(243,197,71,.14);">
                <strong>Application Details</strong><br>
                Business: <?= esc($currentUser['business_name'] ?? 'N/A') ?><br>
                Address: <?= esc($currentUser['business_address'] ?? 'N/A') ?><br>
                <?php if ($currentUser['valid_id']): ?><a href="../../<?= esc($currentUser['valid_id']) ?>" target="_blank" style="color:#f3c547;">View ID</a> <?php endif; ?>
                <?php if ($currentUser['business_permit']): ?> | <a href="../../<?= esc($currentUser['business_permit']) ?>" target="_blank" style="color:#f3c547;">View Permit</a><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="<?= $messageType === 'success' ? 'success' : 'error' ?>"><?= esc($message) ?></div>
        <?php endif; ?>

        <?php if ($currentUser['status'] === 'approved' && $currentUser['role'] !== 'client'): ?>
            <div class="info-box">Your application is approved. You now have <?= esc($currentUser['role']) ?> access.</div>
        <?php else: ?>
            <div class="info-box">Use the buttons below to apply for supplier or coordinator access. Once approved, the admin will grant your account the new role.</div>
            <button class="button" type="button" onclick="showApplication('coordinator')">Apply as Coordinator</button>
            <button class="button" type="button" onclick="showApplication('supplier')">Apply as Supplier</button>

            <form id="applicationForm" class="application-panel" method="POST" enctype="multipart/form-data" style="display:none;">
                <input type="hidden" name="apply_role" id="apply_role" value="supplier">
                <h2>Apply as <span id="applyRoleLabel">Supplier</span></h2>
                <label>Business / Organization Name</label>
                <input type="text" name="business_name" value="<?= esc($currentUser['business_name'] ?? '') ?>" required>
                <label>Business Address</label>
                <input type="text" name="business_address" value="<?= esc($currentUser['business_address'] ?? '') ?>" required>
                <label>Upload Valid ID</label>
                <input type="file" name="valid_id" accept="image/*,.pdf">
                <label>Upload Business Permit</label>
                <input type="file" name="business_permit" accept="image/*,.pdf">
                <label>Live Face Scan</label>
                <div class="video-card">
                    <video id="faceVideo" autoplay playsinline></video>
                </div>
                <canvas id="faceCanvas" width="360" height="250" style="display:none"></canvas>
                <input type="hidden" name="face_capture" id="face_capture">
                <button type="button" class="button" onclick="captureFace()">Capture Face</button>
                <p id="faceStatus" style="margin-top:12px;color:#aaa;font-size:14px;">Camera will open once you select an application type.</p>
                <button type="submit" class="button">Submit Application</button>
            </form>
        <?php endif; ?>

        <a href="../../auth/logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </div>

    <script>
        function showApplication(role) {
            document.getElementById('applicationForm').style.display = 'block';
            document.getElementById('apply_role').value = role;
            document.getElementById('applyRoleLabel').textContent = role === 'supplier' ? 'Supplier' : 'Coordinator';
            startFaceCamera();
        }

        async function startFaceCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                document.getElementById('faceVideo').srcObject = stream;
                document.getElementById('faceStatus').textContent = 'Camera ready. Capture your face when ready.';
            } catch (error) {
                document.getElementById('faceStatus').textContent = 'Camera unavailable. You can still submit the application with files.';
            }
        }

        function captureFace() {
            const video = document.getElementById('faceVideo');
            const canvas = document.getElementById('faceCanvas');
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            document.getElementById('face_capture').value = canvas.toDataURL('image/png');
            document.getElementById('faceStatus').textContent = 'Face captured for admin verification.';
        }
    </script>
</body>
</html>
