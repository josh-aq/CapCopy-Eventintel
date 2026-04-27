<?php
function esc($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventIntel - Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <!-- Left Side - Branding -->
        <div class="left-section">
            <div class="branding-content">
                <h1 class="brand-title">EventIntel</h1>
                <p class="brand-tagline">EventIntel guides every decision with smart recommendations and Ai Generated Event Flow</p>
            </div>
        </div>

        <!-- Right Side - Sign Up Form -->
        <div class="right-section">
            <div class="login-form-container">
                <h2 class="welcome-title">Create Account</h2>
                <?php
                $error = $_GET['error'] ?? '';
                $message = '';
                if ($error === 'missing') $message = 'Please fill in all required fields.';
                elseif ($error === 'exists') $message = 'Username or email already registered.';
                elseif ($_GET['registered'] ?? false) $message = 'Account created! You can now login.';
                elseif ($_GET['pending'] ?? false) $message = 'Account created! Awaiting admin approval.';
                ?>
                <?php if ($message): ?>
                <div style="padding:12px;margin-bottom:15px;border-radius:12px;background:<?=$error ? '#3d1f1f' : '#1f3d1f'?>;border:1px solid <?=$error ? '#c53030' : '#38a169'?>;color:<?=$error ? '#fc8181' : '#9ae6b4'?>"><?=esc($message)?></div>
                <?php endif; ?>
                
                <form class="login-form" action="../auth/register.php" method="POST" enctype="multipart/form-data">
                    <!-- Name Fields -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="icon fas fa-user"></i>
                                <input type="text" name="first_name" placeholder="First Name" class="input-field" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="icon fas fa-user"></i>
                                <input type="text" name="last_name" placeholder="Last Name" class="input-field" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="icon fas fa-user"></i>
                                <input type="text" name="middle_initial" placeholder="Middle Initial" class="input-field" maxlength="1">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Email Address" class="input-field" required>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-user-circle"></i>
                            <input type="text" name="username" placeholder="Username" class="input-field" required>
                        </div>
                    </div>

                    <!-- Age and Gender -->
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="icon fas fa-birthday-cake"></i>
                                <input type="number" name="age" placeholder="Age" class="input-field" min="18" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="input-field select-field" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-phone"></i>
                            <input type="tel" name="phone" placeholder="Phone Number" class="input-field" required>
                        </div>
                    </div>

                    <!-- Address Fields -->
                    <div class="address-section">
                        <p class="section-title">Address Information</p>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <i class="icon fas fa-map-pin"></i>
                                    <input type="text" name="province" placeholder="Province" class="input-field" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <i class="icon fas fa-map-pin"></i>
                                    <input type="text" name="municipality" placeholder="Municipality" class="input-field" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <i class="icon fas fa-map-pin"></i>
                                    <input type="text" name="barangay" placeholder="Barangay" class="input-field" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-wrapper">
                                    <i class="icon fas fa-map-pin"></i>
                                    <input type="text" name="postal_code" placeholder="Postal Code" class="input-field" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="role-section">
                        <p class="section-title">Account Type</p>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="radio" name="role" value="coordinator" class="checkbox-input">
                                <span class="checkbox-text"><i class="fas fa-clipboard-list"></i> Sign Up as Coordinator</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" name="role" value="supplier" class="checkbox-input">
                                <span class="checkbox-text"><i class="fas fa-box"></i> Sign Up as Supplier</span>
                            </label>
                        </div>
                        <label class="checkbox-label">
                            <input type="radio" name="role" value="client" class="checkbox-input" checked>
                            <span class="checkbox-text"><i class="fas fa-user"></i> Sign Up as Client</span>
                        </label>
                    </div>

                    <div id="verificationFields" style="display:none; margin:15px 0; padding:14px; border:1px solid rgba(255,215,0,.25); border-radius:14px;">
                        <p class="section-title">Supplier/Coordinator Verification</p>
                        <div class="form-group"><div class="input-wrapper"><i class="icon fas fa-building"></i><input type="text" name="business_name" placeholder="Business / Organization Name" class="input-field"></div></div>
                        <div class="form-group"><div class="input-wrapper"><i class="icon fas fa-location-dot"></i><input type="text" name="business_address" placeholder="Business Address" class="input-field"></div></div>
                        <p style="font-size:12px;color:#aaa;margin:8px 0;">Upload Valid ID</p><input type="file" name="valid_id" accept="image/*,.pdf" class="input-field">
                        <p style="font-size:12px;color:#aaa;margin:8px 0;">Upload Business Permit</p><input type="file" name="business_permit" accept="image/*,.pdf" class="input-field">
                        <p style="font-size:12px;color:#f3c547;margin:12px 0;">Live Face Scan for admin comparison with ID</p>
                        <video id="faceVideo" autoplay playsinline style="width:100%;max-height:220px;border-radius:14px;background:#111;"></video>
                        <canvas id="faceCanvas" width="360" height="250" style="display:none;"></canvas>
                        <input type="hidden" name="face_capture" id="face_capture">
                        <button type="button" class="login-button" style="margin-top:10px;" onclick="captureFace()">Capture Face</button>
                        <p id="faceStatus" style="font-size:12px;color:#aaa;text-align:center;margin-top:6px;">Camera will open when Supplier/Coordinator is selected.</p>
                    </div>

                    <!-- Passwords -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" class="input-field" id="password" required>
                            <span class="toggle-password" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-lock"></i>
                            <input type="password" name="confirm_password" placeholder="Confirm Password" class="input-field" id="confirm-password" required>
                            <span class="toggle-password" onclick="togglePassword('confirm-password')"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>

                    <button type="submit" class="login-button">Sign Up</button>
                </form>

                <div class="signup-section">
                    <p class="signup-text">Already have an account? <a href="index.php" class="signup-link">Log In</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = event.target.closest('.toggle-password').querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    
        document.querySelectorAll('input[name="role"]').forEach(r=>{
            r.addEventListener('change',()=>{
                const isVerify = r.value !== 'client' && r.checked;
                document.getElementById('verificationFields').style.display = isVerify ? 'block':'none';
                if(isVerify) startFaceCamera();
            });
        });
        async function startFaceCamera(){
            try{
                const stream = await navigator.mediaDevices.getUserMedia({video:true});
                document.getElementById('faceVideo').srcObject = stream;
            }catch(e){ document.getElementById('faceStatus').textContent = 'Camera unavailable. Admin may request manual verification.'; }
        }
        function captureFace(){
            const v=document.getElementById('faceVideo'), c=document.getElementById('faceCanvas');
            c.getContext('2d').drawImage(v,0,0,c.width,c.height);
            document.getElementById('face_capture').value = c.toDataURL('image/png');
            document.getElementById('faceStatus').textContent = 'Face captured for admin verification.';
        }
    </script>
</body>
</html>
