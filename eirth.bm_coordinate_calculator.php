<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>🌍 BM Coordinate Calculator</title>
<link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
<style>
    body {
        font-family: 'SolaimanLipi', sans-serif;
        background: #f0f5f5;
        padding: 30px;
        color: #222;
    }
    h1 {
        text-align: center;
        color: #00695c;
    }
    form {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        max-width: 500px;
        margin: auto;
    }
    input, select, button {
        width: 100%;
        padding: 10px;
        margin: 6px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
        background: #009688;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background: #00796b;
    }
    .result {
        background: #e0f2f1;
        border-radius: 12px;
        padding: 15px;
        margin-top: 25px;
    }
    .link {
        margin-top: 10px;
        text-align: center;
    }
    .link a {
        color: #00695c;
        text-decoration: none;
        font-weight: bold;
    }
</style>
</head>
<body>

<h1>🌍 BM Coordinate Calculator</h1>

<form method="post">
    <label>Coordinate Type:</label>
    <select name="type">
        <option value="decimal">Decimal Degree (25.122426, 91.377912)</option>
        <option value="dms">DMS Format (25°06'50.74"N, 91°22'54.38"E)</option>
    </select>

    <label>Latitude / DMS:</label>
    <input type="text" name="lat" placeholder="25.122426 বা 25°06'50.74&quot;N" required>

    <label>Longitude / DMS:</label>
    <input type="text" name="lon" placeholder="91.377912 বা 91°22'54.38&quot;E" required>

    <label>Bearing (ডিগ্রী):</label>
    <input type="number" name="bearing" step="any" required>

    <label>Distance (ফুট):</label>
    <input type="number" name="distance" step="any" required>

    <button type="submit">✅ Calculate</button>
</form>

<?php
function dms_to_dd($deg, $min, $sec, $dir) {
    $dd = floatval($deg) + floatval($min)/60 + floatval($sec)/3600;
    if (in_array(strtoupper($dir), ["S", "W"])) $dd *= -1;
    return $dd;
}

function to_dms($value, $type) {
    $deg = intval($value);
    $minutes_full = abs(($value - $deg) * 60);
    $min = intval($minutes_full);
    $sec = ($minutes_full - $min) * 60;
    $dir = ($type == "lat") ? ($value >= 0 ? "N" : "S") : ($value >= 0 ? "E" : "W");
    return sprintf("%d°%02d'%05.2f\"%s", abs($deg), $min, $sec, $dir);
}

function parse_dms($dms) {
    $pattern = '/(\d+)°(\d+)\'([\d.]+)"?([NSEW])/';
    if (preg_match($pattern, trim($dms), $m)) {
        return dms_to_dd($m[1], $m[2], $m[3], $m[4]);
    } else {
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $lat_input = trim($_POST['lat']);
    $lon_input = trim($_POST['lon']);
    $bearing = floatval($_POST['bearing']);
    $dist_ft = floatval($_POST['distance']);
    $dist_m = $dist_ft * 0.3048;

    if ($type == 'dms') {
        $lat1 = parse_dms($lat_input);
        $lon1 = parse_dms($lon_input);
    } else {
        $lat1 = floatval($lat_input);
        $lon1 = floatval($lon_input);
    }

    if ($lat1 !== null && $lon1 !== null) {
        $lat1_rad = deg2rad($lat1);
        $bearing_rad = deg2rad($bearing);

        $dlat = ($dist_m * cos($bearing_rad)) / 111320;
        $dlon = ($dist_m * sin($bearing_rad)) / (111320 * cos($lat1_rad));

        $lat2 = $lat1 + $dlat;
        $lon2 = $lon1 + $dlon;

        $lat2_dms = to_dms($lat2, "lat");
        $lon2_dms = to_dms($lon2, "lon");
        $map_link = "https://www.google.com/maps?q={$lat2},{$lon2}";

        echo "<div class='result'>";
        echo "<h3>✅ ফলাফল</h3>";
        echo "<p><b>মূল স্থানাঙ্ক:</b> {$lat1}, {$lon1}</p>";
        echo "<p><b>দূরত্ব:</b> {$dist_ft} ft  ({$dist_m} m)</p>";
        echo "<p><b>দিক:</b> {$bearing}°</p>";
        echo "<hr>";
        echo "<p><b>নতুন স্থানাঙ্ক (DD):</b> {$lat2}, {$lon2}</p>";
        echo "<p><b>নতুন স্থানাঙ্ক (DMS):</b> {$lat2_dms}, {$lon2_dms}</p>";
        echo "<div class='link'><a href='$map_link' target='_blank'>🔗 Google Maps Link</a></div>";
        echo "</div>";
    } else {
        echo "<p style='color:red; text-align:center;'>⚠️ Invalid DMS format!</p>";
    }
}
?>

</body>
</html>
