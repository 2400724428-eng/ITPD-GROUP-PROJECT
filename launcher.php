<?php
// Pure Gain — Standalone Splash Launcher
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/images/fav.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure Gain - Loading...</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: "Inter", sans-serif;
            background: #f8fafc;
        }

        .splash-screen {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background:
                radial-gradient(
                    circle at 50% 45%,
                    rgba(37, 99, 235, 0.08),
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #f8fafc 0%,
                    #f1f5f9 48%,
                    #e2e8f0 100%
                );
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .splash-screen.fade-out {
            opacity: 0;
            transform: scale(1.03);
            pointer-events: none;
        }

        .splash-ambient {
            position: absolute;
            width: min(700px, 120vw);
            height: min(700px, 120vw);
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.06);
            filter: blur(100px);
            animation: ambientPulse 5s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes ambientPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(.95); }
            50% { transform: translate(-50%, -50%) scale(1.12); }
        }

        .splash-content {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
            width: 100%;
        }

        .splash-logo-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            animation: logoFloat 3.5s ease-in-out infinite;
        }

        .splash-logo-glow {
            position: absolute;
            width: min(190px, 50vw);
            height: min(190px, 50vw);
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.15);
            filter: blur(40px);
            animation: logoGlow 4s ease-in-out infinite;
        }

        .splash-logo {
            position: relative;
            z-index: 2;
            width: min(240px, 65vw);
            max-height: 110px;
            object-fit: contain;
            filter: drop-shadow(0 8px 20px rgba(15,23,42,.08));
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes logoGlow {
            0%, 100% { transform: scale(.85); opacity: .5; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        .splash-spinner {
            width: 34px;
            height: 34px;
            border: 3px solid rgba(37, 99, 235, 0.15);
            border-top: 3px solid #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="splash-screen" id="splashScreen">
        <div class="splash-ambient"></div>
        <div class="splash-content">
            <div class="splash-logo-wrapper">
                <div class="splash-logo-glow"></div>
                <img src="assets/images/logos.png" alt="Pure Gain Supplements" class="splash-logo">
            </div>
            <div class="splash-spinner"></div>
        </div>
    </div>

    <script>
        // Smoothly fade out the launcher and redirect to your main site file (home.php)
        window.addEventListener("load", () => {
            setTimeout(() => {
                const splash = document.getElementById("splashScreen");
                splash.classList.add("fade-out");
                setTimeout(() => {
                    window.location.href = "index.php";
                }, 600);
            }, 2500);
        });
    </script>

</body>
</html>