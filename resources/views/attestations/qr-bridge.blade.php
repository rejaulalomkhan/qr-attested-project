<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <style>
        body { margin:0; height:100vh; display:flex; align-items:center; justify-content:center; font: 500 16px/1 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial; color:#333; }
        .spinner { width: 48px; height: 48px; border: 4px solid rgba(37,99,235,.2); border-top-color: #2563eb; border-radius: 50%; animation: spin .8s linear infinite; margin-right: 10px; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    <script>
        (function() {
            function decodeToken(fragment) {
                try {
                    var token = fragment.replace(/^#\/?page\/preview\//i, '');
                    if (!token) return null;
                    var decoded = decodeURIComponent(token);
                    // atob expects non-url-encoded base64
                    var hash = atob(decoded);
                    return hash || null;
                } catch (e) {
                    return null;
                }
            }

            function go() {
                var hash = decodeToken(window.location.hash || '');
                if (!hash) {
                    document.getElementById('msg').textContent = 'Invalid QR link';
                    return;
                }
                // Redirect to the canonical verify route
                window.location.replace('/verify/' + encodeURIComponent(hash));
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', go);
            } else {
                go();
            }
        })();
    </script>
    <noscript>
        <meta http-equiv="refresh" content="0;url=/" />
    </noscript>
</head>
<body>
    <div style="display:flex; align-items:center;">
        <div class="spinner" aria-hidden="true"></div>
        <div id="msg">Loading…</div>
    </div>
</body>
</html>


