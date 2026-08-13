<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Perpustakaan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffe5ec 0%, #f0e6ff 50%, #fff0e6 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            overflow-x: hidden;
        }

        /* --- KOTAK UTAMA (FORM CONTAINER) --- */
        .container {
            width: 100%;
            max-width: 650px;
            background: rgba(255, 250, 245, 0.85);
            padding: 40px;
            border-radius: 35px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.6);
            
            box-shadow: 
                0 10px 20px rgba(232, 138, 163, 0.1),
                inset 0 -10px 20px rgba(232, 138, 163, 0.05),
                inset 0 10px 20px rgba(255, 255, 255, 0.8);
            
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        /* EFEK NGAMBANG CONTAINER UTAMA */
        .container:hover {
            transform: translateY(-12px) scale(1.01);
            box-shadow: 
                0 30px 60px rgba(232, 138, 163, 0.25),
                inset 0 -5px 15px rgba(232, 138, 163, 0.02),
                inset 0 10px 20px rgba(255, 255, 255, 0.9);
        }

        .container::before {
            content: "🌸";
            position: absolute;
            font-size: 30px;
            top: -20px;
            right: 20px;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h2 {
            text-align: center;
            color: #d67180;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            margin-top: 0;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease;
        }
        
        .container:hover h2 {
            transform: scale(1.05);
        }

        /* Grid System */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            position: relative; /* Penting untuk posisi ikon mata */
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #7d6b6b;
            margin-bottom: 6px;
            margin-left: 8px;
        }

        /* --- INPUT & TEXTAREA --- */
        input, textarea {
            width: 100%;
            padding: 14px 18px;
            font-size: 14px;
            border-radius: 20px;
            border: 1px solid rgba(243, 214, 198, 0.7);
            background: rgba(255, 248, 240, 0.7);
            color: #5a4b4b;
            font-family: inherit;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            
            box-shadow: 
                inset 0 4px 8px rgba(243, 214, 198, 0.2),
                0 2px 4px rgba(255, 255, 255, 0.5);
        }

        /* Khusus input password diberi padding kanan lebih besar agar teks tidak tertutup ikon */
        input[type="password"], input[type="text"]#password {
            padding-right: 45px;
        }

        input:hover, textarea:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.9);
            border-color: #f8a5c2;
            box-shadow: 0 6px 15px rgba(232, 138, 163, 0.15);
        }

        input:focus, textarea:focus {
            background: #ffffff;
            border-color: #e88aa3;
            outline: none;
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 10px 20px rgba(232, 138, 163, 0.2),
                0 0 0 4px rgba(232, 138, 163, 0.15);
        }

        /* 🔥 STYLE TOMBOL MATA UNTUK PASSWORD 🔥 */
        .password-toggle {
            position: absolute;
            right: 18px;
            top: 43px; /* Menyesuaikan posisi di tengah input */
            color: #a39292;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #e88aa3;
            transform: scale(1.1);
        }

        textarea {
            height: 90px;
            resize: none;
        }

        /* --- TOMBOL DAFTAR --- */
        button {
            width: 100%;
            margin-top: 15px;
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, #ff9ebb, #ffc285);
            color: white;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            
            box-shadow: 
                0 6px 15px rgba(255, 158, 187, 0.3),
                inset 0 -5px 10px rgba(0, 0, 0, 0.08),
                inset 0 5px 10px rgba(255, 255, 255, 0.3);
        }

        button:hover {
            transform: translateY(-6px) rotate(-1deg);
            box-shadow: 
                0 15px 25px rgba(255, 158, 187, 0.5),
                inset 0 -3px 8px rgba(0, 0, 0, 0.08),
                inset 0 5px 10px rgba(255, 255, 255, 0.4);
            filter: brightness(1.03);
        }

        button:active {
            transform: translateY(2px) rotate(0deg);
            box-shadow: 
                0 4px 8px rgba(255, 158, 187, 0.2),
                inset 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .login {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #7d6b6b;
            font-weight: 500;
            transition: transform 0.3s ease;
        }
        
        .container:hover .login {
            transform: translateY(2px);
        }

        .login a {
            color: #d67180;
            text-decoration: none;
            font-weight: 700;
            margin-left: 3px;
            border-bottom: 2px dashed rgba(214, 113, 128, 0.3);
            transition: 0.2s;
        }
        
        .login a:hover {
            border-bottom-color: #d67180;
            color: #b35361;
        }

        @media (max-width: 500px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .container { padding: 25px; }
            .container:hover { transform: translateY(-6px); }
            .password-toggle { top: 40px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar akun dulu yaa</h2>

    <form method="POST" action="proses_register.php">
        <div class="form-grid">
            
            <div class="form-group">
                <label>User ID</label>
                <input type="text" name="userid" required placeholder="ID Unik kamu...">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Nama pengguna...">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="Kata sandi...">
                <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="contoh@gmail.com">
            </div>

            <div class="form-group full-width">
                <label>Nama Lengkap</label>
                <input type="text" name="namalengkap" required placeholder="Nama lengkap sesuai identitas...">
            </div>

            <div class="form-group full-width">
                <label>Alamat</label>
                <textarea name="alamat" required placeholder="Tulis alamat rumah lengkap kamu saat ini..."></textarea>
            </div>
            
            <div class="form-group full-width">
                <button type="submit" name="daftar">DAFTAR SEKARANG</button>
            </div>

        </div>
    </form>

    <div class="login">
        Sudah punya akun manis? <a href="index.php">Login di sini</a>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Cek tipe input saat ini, kalau password ubah ke text, kalau text ubah ke password
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Ubah ikon mata biasa menjadi mata dicoret (slash) saat password terlihat
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>