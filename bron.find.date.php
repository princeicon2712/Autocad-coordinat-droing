<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['u'];
    $m = $_POST['m'];
    $t = $_POST['t'];

    $url = "https://www.easyseba.shop/birth_date_info.php";

    $data = http_build_query([
        'u' => $u,
        'm' => $m,
        't' => $t
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36'
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "<h3 style='color:red;'>cURL Error: " . curl_error($ch) . "</h3>";
    }

    curl_close($ch);

    echo "<h3 style='color:#0f5132;'>API Response:</h3>";

    $decoded = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<pre style='background:#d4edda;color:#155724;padding:10px;border-radius:10px;'>" . 
             htmlspecialchars(json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . 
             "</pre>";
    } else {
        echo "<pre style='background:#d4edda;color:#155724;padding:10px;border-radius:10px;'>" . 
             htmlspecialchars($response) . 
             "</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EasySeba API Test 💚</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 30px;
    background: linear-gradient(to right, #00b894, #55efc4);
    color: #0f5132;
}
form {
    background-color: rgba(255,255,255,0.1);
    padding: 25px;
    border-radius: 15px;
    max-width: 400px;
}
input[type=text] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    border: 1px solid #0f5132;
}
input[type=submit] {
    padding: 10px 20px;
    background-color: #00b894;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}
input[type=submit]:hover {
    background-color: #019875;
}
h2 {
    color: #0f5132;
}
</style>
</head>
<body>
<h2>EasySeba Birth Date Info API 💚</h2>

<form method="post">
    <label for="u">UBRN Number (u):</label><br>
    <input type="text" id="u" name="u" placeholder="What is the UBRN?" required><br>

    <label for="m">Mode (m):</label><br>
    <input type="text" id="m" name="m" value="1" required><br>

    <label for="t">Token / Session (t):</label><br>
    <input type="text" id="t" name="t" value="api-v2-script[session=cb2221b3d18913147712c6c1c23311d5]" required><br>

    <input type="submit" value="Send Request">
</form>
</body>
</html>
