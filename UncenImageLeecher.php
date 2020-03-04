<title>Uncen.net 18+ Image Leecher by LilShieru</title>
<h1>Uncen.net 18+ Image Leecher</h1>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<style>

#list {
  /* Remove default list styling */
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#list li a {
  border: 1px solid #ddd; /* Add a border to all links */
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6; /* Grey background color */
  padding: 12px; /* Add some padding */
  text-decoration: none; /* Remove default text underline */
  font-size: 18px; /* Increase the font-size */
  color: black; /* Add a black text color */
  display: block; /* Make it into a block element to fill the whole list */
}

#list li a:hover:not(.header) {
  background-color: #eee; /* Add a hover effect to all links, except for headers */
}
</style>
<?php
if ($_GET["leakUrl"] == "") {
    echo '<h3>Chọn một mục cần leech:</h3>';
}
else {
    echo '<h3 id="name">Đang xem mục </h3><br><button onclick="View()" style="font-size:20pt">Xem ảnh</button> <button onclick="BBCode()" style="font-size:20pt">Lấy BBCode</button><br><br><div id="results"></div><br><div>Nếu không thấy ảnh ở bên trên dòng này, hãy thử tải lại trang.</div>';
}
?>
<ul id="list"></ul>
<div id="result" style="display:none">
<?php
if ($_GET["leakUrl"] == "") {
   $lurl=get_fcontent("http://uncen.net");
   echo $lurl[0];
}
else {
   $lurl=get_fcontent($_GET["leakUrl"]);
   echo $lurl[0];
}

function get_fcontent( $url,  $javascript_loop = 0, $timeout = 5 ) {
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
    curl_close ( $ch );

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ( $headers = get_headers($response['url']) ) {
            foreach( $headers as $value ) {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return get_url( trim( substr( $value, 9, strlen($value) ) ) );
            }
        }
    }

    if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
        return get_url( $value[1], $javascript_loop+1 );
    } else {
        return array( $content, $response );
    }
}

?>
</div>
<?php
if ($_GET["leakUrl"] == "") {
    echo '<br><br><div>Nếu không thấy mục nào trong danh sách, hãy thử tải lại trang.</div><script>
        for (var i = 0; i < document.getElementsByClassName(\'section pt-0\')[0].getElementsByClassName(\'book__img-inner\').length; i++) {
            document.getElementById(\'list\').innerHTML += "<li><a href=\'https://lilshieru.ga/UncenImgLeaker.php?leakUrl=" + document.getElementsByClassName(\'section pt-0\')[0].getElementsByClassName(\'book\')[i].getAttribute(\'href\') + "\'>" + document.getElementsByClassName(\'section pt-0\')[0].getElementsByClassName(\'book__img-inner\')[i].getElementsByClassName(\'book__chapter\')[0].innerText + "</a></li><br>";
        }
    </script>';
}
else {
    echo '<script>
        document.getElementById("name").innerHTML += document.getElementsByClassName("book-detail-header")[0].getElementsByTagName("h1")[0].innerText + " | <a href=\'javascript:history.go(-1)\'>Trở về trang trước</a>";
    </script>';
}
?>
<script>
    var bbcode = false, view = false;
    function View() {
        if (!view) {
            for (var i = 0; i < images.length; i++) {
                document.getElementById("results").innerHTML += "<img src='" + images[i] + "'/><br><br>";
            }
            view = true;
        }
    }
    function BBCode() {
        if (!bbcode) {
            var code = "<textarea style='width:100%;height:400px'>";
            for (var i = 0; i < images.length; i++) {
                code += "[img]" + images[i] + "[/img]\n";
            }
            code += "</textarea><br><br>"
            document.getElementById("results").innerHTML = code + document.getElementById("results").innerHTML;
            bbcode = true;
        }
    }
</script>
