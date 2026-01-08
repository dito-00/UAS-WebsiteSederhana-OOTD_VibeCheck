<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VibeCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('public/img/wallpaper.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: #fff;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        /* Style Logo Baru */
        .brand-logo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            object-fit: cover;
            animation: pulse 3s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
            50% { transform: scale(1.03); box-shadow: 0 12px 25px rgba(255,255,255,0.3); }
            100% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 { font-weight: 700; font-size: 2.2rem; letter-spacing: -1px; margin-bottom: 5px; }
        .subtitle { font-size: 0.9rem; opacity: 0.9; margin-bottom: 35px; }

        .form-control {
            background: rgba(255, 255, 255, 0.9) !important;
            border: none !important;
            border-radius: 15px !important;
            padding: 14px 20px !important;
            font-size: 0.95rem !important;
        }

        .password-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;
            font-size: 1.2rem;
            z-index: 10;
        }

        .btn-login {
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 15px;
            padding: 14px;
            width: 100%;
            font-weight: 600;
            letter-spacing: 1px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-login:hover {
            background: #000;
            transform: translateY(-3px);
            color: #fff;
        }

        .footer-text { margin-top: 25px; font-size: 0.85rem; }
        .register-link {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            transition: 0.3s;
        }

        .register-link:hover { border-bottom: 2px solid #fff; }

        .swal-input-group {
            position: relative;
            width: 100%;
            margin-top: 15px;
        }
        .swal-toggle {
            position: absolute;
            right: 40px;
            top: 25px;
            cursor: pointer;
            color: #666;
            z-index: 100;
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="public/img/logo.jpg" alt="VibeCheck Logo" class="brand-logo">
    
    <h2>VibeCheck</h2>
    <p class="subtitle">Atur lemari pakaianmu, Tentukan gayamu.</p>

    <form action="index.php?url=auth" method="POST">
        <div class="mb-3 text-start">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        
        <div class="password-wrapper text-start">
            <input type="password" name="password" id="loginPass" class="form-control" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePass('loginPass', this)">👁️</span>
        </div>

        <button type="submit" class="btn btn-login">SIGN IN</button>
    </form>

    <div class="footer-text">
        Belum punya akun? 
        <a href="javascript:void(0)" onclick="showRegister()" class="register-link">Daftar Sekarang</a>
    </div>
</div>

<script>
    function togglePass(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈";
        } else {
            input.type = "password";
            icon.textContent = "👁️";
        }
    }

    const params = new URLSearchParams(window.location.search);
    if (params.get('msg')) {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: params.get('msg'), confirmButtonColor: '#1a1a1a' });
    }
    if (params.get('error')) {
        Swal.fire({ icon: 'error', title: 'Oops!', text: params.get('error'), confirmButtonColor: '#1a1a1a' });
    }

    function showRegister() {
        Swal.fire({
            title: '<strong>Join VibeCheck</strong>',
            html: `
                <p class="text-muted small mb-3">Buat akun untuk mengelola koleksi bajumu.</p>
                <div class="text-start mb-3">
                    <input id="reg-user" class="swal2-input m-0 w-100" style="border-radius:15px" placeholder="Buat Username">
                </div>
                <div class="swal-input-group text-start">
                    <input id="reg-pass" type="password" class="swal2-input m-0 w-100" style="border-radius:15px" placeholder="Buat Password">
                    <span class="swal-toggle" onclick="togglePass('reg-pass', this)">👁️</span>
                </div>
                <div class="text-start mt-2">
                    <small style="color:#888; font-size: 0.75rem;">Gunakan password yang mudah diingat.</small>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Daftar Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#1a1a1a',
            preConfirm: () => {
                const username = document.getElementById('reg-user').value;
                const password = document.getElementById('reg-pass').value;
                if (!username || !password) {
                    Swal.showValidationMessage('Data tidak boleh kosong!');
                }
                return { username: username, password: password }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php?url=register_process';
                
                const uInput = document.createElement('input');
                uInput.type = 'hidden'; uInput.name = 'username'; uInput.value = result.value.username;
                form.appendChild(uInput);
                
                const pInput = document.createElement('input');
                pInput.type = 'hidden'; pInput.name = 'password'; pInput.value = result.value.password;
                form.appendChild(pInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

</body>
</html>