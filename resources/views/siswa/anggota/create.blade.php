<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota — Perpustakaan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --pink:   #f9a8d4;
            --blue:   #a5d8ff;
            --mint:   #a7f3d0;
            --yellow: #fde68a;
            --purple: #c4b5fd;
            --text:   #374151;
            --muted:  #9ca3af;
            --border: #e5e7eb;
            --white:  #ffffff;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .bg-shapes {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.35;
            animation: float linear infinite;
        }

        .shape-1 { width: 320px; height: 320px; background: var(--pink); top: -80px; left: -80px; animation-duration: 18s; }
        .shape-2 { width: 200px; height: 200px; background: var(--blue); bottom: -60px; right: -60px; animation-duration: 22s; animation-delay: -4s; }
        .shape-3 { width: 140px; height: 140px; background: var(--mint); top: 60%; left: 10%; animation-duration: 15s; animation-delay: -8s; }
        .shape-4 { width: 100px; height: 100px; background: var(--yellow); top: 20%; right: 12%; animation-duration: 20s; animation-delay: -2s; }
        .shape-5 { width: 80px; height: 80px; background: var(--purple); bottom: 20%; left: 40%; animation-duration: 17s; animation-delay: -6s; }

        @keyframes float {
            0%   { transform: translateY(0px) rotate(0deg); }
            33%  { transform: translateY(-20px) rotate(5deg); }
            66%  { transform: translateY(10px) rotate(-3deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .card {
            position: relative;
            z-index: 1;
            background: var(--white);
            border-radius: 24px;
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            animation: slideUp 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #fbcfe8, #a5d8ff);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
        }

        .subtitle {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 32px;
        }

        .alert {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        input {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            background: #fafafa;
            outline: none;
        }

        input:focus {
            border-color: #a5d8ff;
            box-shadow: 0 0 0 3px rgba(165,216,255,0.25);
            background: var(--white);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #fbcfe8, #a5d8ff);
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            cursor: pointer;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(165,216,255,0.4);
        }

        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--muted);
        }
    </style>
</head>

<body>

<div class="bg-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
</div>

<div class="card">

    <div class="logo-wrap">
        <div class="logo-icon">📚</div>
        <span class="logo-text">Daftar Sebagai Anggota</span>
    </div>

    <p class="subtitle">
        Anda harus terdaftar sebagai anggota perpustakaan untuk mengakses layanan yang tersedia
    </p>

    @if ($errors->any())
        <div class="alert">
            <span>⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('siswa.anggota.store') }}" id="anggotaForm">

        @csrf

        <div class="form-group">
            <label>NIS</label>

            <div class="input-wrap">
                <span class="icon">👤</span>

                <input
                    type="text"
                    name="nis"
                    value="{{ auth()->user()->nis }}"
                    required>
            </div>
        </div>

        <div class="form-group">
            <label>Kelas</label>

            <div class="input-wrap">
                <span class="icon">🏫</span>

                <input
                    type="text"
                    name="kelas"
                    placeholder="Masukkan kelas"
                    required>
            </div>
        </div>

        <button type="submit" class="btn-login" id="submitBtn">
            Daftar Anggota
        </button>

    </form>

    <p class="footer-note">
        Pastikan data valid
    </p>

</div>

<script>

document.getElementById('anggotaForm')
.addEventListener('submit', function () {

    const btn = document.getElementById('submitBtn');

    btn.disabled = true;

    btn.innerHTML =
        '<span style="border:2px solid rgba(55,65,81,0.3);border-top-color:#374151;border-radius:50%;width:16px;height:16px;display:inline-block;animation:spin 0.7s linear infinite;margin-right:6px;"></span> Memproses...';

});

</script>

</body>
</html>