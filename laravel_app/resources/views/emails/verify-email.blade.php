<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 40px; margin-bottom: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #ffffff; padding: 24px; text-align: center; border-bottom: 1px solid #e5e7eb; }
        .content { padding: 32px 24px; text-align: center; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
        
        /* Tombol Hover Effect (Hanya jalan di client modern, tapi aman) */
        .btn-primary:hover { opacity: 0.9; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2 style="margin:0; font-size: 32px; font-weight: 700; color: #0a3c78;">UMKM SASUMA</h2>
        </div>

        <div class="content">
            <h1 style="margin-top: 0; color: #111827; font-size: 24px; font-weight: 700;">Halo, {{ $user->name }}!</h1>
            
            <p style="line-height: 1.6; font-size: 16px; margin-bottom: 24px; color: #374151;">
                Terima kasih telah mendaftar. Mohon verifikasi alamat email Anda untuk mengaktifkan akun dan mulai menggunakan layanan kami.
            </p>

            <div style="margin: 32px 0;">
                <a href="{{ $url }}" 
   target="_blank"
   style="display: inline-block; 
          background-color: #FFC107; /* bg-brand-yellow */
          color: #111827;            /* text-slate-900 */
          font-weight: 500;          /* font-medium */
          border-radius: 8px;        /* rounded-lg */
          padding: 12px 24px;        /* Padding standard tombol */
          text-decoration: none;     /* Hilangkan garis bawah link */
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
          font-family: 'Plus Jakarta Sans', sans-serif;
          font-size: 16px;">
    Verifikasi Email Saya
</a>
            </div>

            <p style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:<br>
                <a href="{{ $url }}" style="color: #2563eb; word-break: break-all;">{{ $url }}</a>
            </p>

            <p style="margin-top: 24px; color: #374151; font-size: 16px;">
                Jika Anda tidak merasa mendaftar, silakan abaikan email ini.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} UMKM Sasuma. All rights reserved.
        </div>
    </div>

</body>
</html>
