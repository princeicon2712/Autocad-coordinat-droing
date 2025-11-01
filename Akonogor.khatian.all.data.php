<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>খতিয়ান দিয়ে Holding ID খোঁজ</title>
    <style>
        body { font-family: Arial; background: #f3f3f3; padding: 30px; }
        form { background: #fff; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px #ccc; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; font-size: 16px; }
        .result { background: #fff; padding: 20px; margin-top: 20px; border-radius: 10px; max-width: 500px; margin: auto; }
        a { color: blue; }
    </style>
</head>
<body>

<h2 style="text-align:center;">🔍 খতিয়ান দিয়ে খোঁজ করুন(R.S) Akonogor</h2>

<form method="POST">
    <label>🔢 খতিয়ান নম্বর দিন:</label>
    <input type="text" name="khotian_no" required>
    <button type="submit">✅ সাবমিট করুন</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["khotian_no"])) {
    $khotian_no = htmlspecialchars($_POST["khotian_no"]);

    $url = "https://api.ldtax.gov.bd/api/v1/holding-list-for-representative-payment?akonogor=";

    $payload = json_encode([
        "division_id" => 7,
        "district_id" => 61,
        "upazila_id" => 502,
        "mouja_id" => 104519,
        "khotian_no" => $khotian_no,
        "holding_no" => "",
        "holding_type" => 0
    ]);

    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
        "User-Agent: Mozilla/5.0",
        "Origin: https://portal.ldtax.gov.bd",
        "Referer: https://portal.ldtax.gov.bd/",
        "X-Requested-With: XMLHttpRequest"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "<div class='result'>";
    if ($httpcode == 200 && !empty($response)) {
        $data = json_decode($response, true);

        if (isset($data['data']) && count($data['data']) > 0) {
            echo "<h3>✅ পাওয়া গেছে:</h3>";
            foreach ($data['data'] as $row) {
                $id = $row["id"];
                $holding_no = $row["holding_no"];
                $owner = $row["owner_name"];
                $link = "https://office.ldtax.gov.bd/holding/citizen-calculation?holding_id=$id";

                echo "🆔 Holding ID: $id<br>";
                echo "🏠 Holding No: $holding_no<br>";
                echo "👤 মালিক: $owner<br>";
                echo "🔗 <a href='$link' target='_blank'>Holding Link</a><br><br>";
            }
        } else {
            echo "❌ কোনো তথ্য পাওয়া যায়নি খতিয়ান নম্বর <strong>$khotian_no</strong> এর জন্য।";
        }
    } else {
        echo "⚠️ সার্ভার থেকে সঠিক রেসপন্স পাওয়া যায়নি। HTTP Code: $httpcode";
    }
    echo "</div>";
}
?>
</body>
</html>
