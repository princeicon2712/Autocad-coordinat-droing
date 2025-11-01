<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>Text File / Input to Unlimited A4 Pages</title>
<style>
body { font-family: Arial; background: #f3f3f3; padding: 30px; }
form { background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 0 10px #ccc; }
input, textarea, button { width: 100%; padding: 10px; margin-top: 10px; font-size: 16px; }
.result { background: #fff; padding: 20px; margin-top: 20px; border-radius: 10px; max-width: 800px; margin: auto; }
.page { page-break-after: always; white-space: pre-wrap; margin-bottom: 30px; }
#printBtn { background: green; color: white; padding: 10px 15px; border: none; cursor: pointer; font-size: 16px; margin-top: 10px; }
@media print {
    body { background: #fff; padding: 0; }
    form, #printBtn { display: none; }
    .result { width: 100%; margin: 0; padding: 0; }
    .page { page-break-after: always; margin: 0; padding: 0; }
}
</style>
</head>
<body>

<h2 style="text-align:center;">📄 Text Input / File থেকে Unlimited A4 Pages</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Text লিখুন বা ফাইল আপলোড করুন:</label>
    <textarea name="user_text" rows="8" placeholder="এখানে লিখুন..." ></textarea>
    <input type="file" name="text_file" accept=".txt">
    <button type="submit">✅ সাবমিট করুন</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $text = "";

    // Textarea থেকে
    if (!empty($_POST["user_text"])) {
        $text .= $_POST["user_text"];
    }

    // File থেকে
    if (isset($_FILES["text_file"]) && $_FILES["text_file"]["error"] == 0) {
        $file_ext = pathinfo($_FILES["text_file"]["name"], PATHINFO_EXTENSION);
        if ($file_ext == "txt") {
            $text .= "\n" . file_get_contents($_FILES["text_file"]["tmp_name"]);
        }
    }

    if (!empty($text)) {
        // A4 approx lines per page
        $lines_per_page = 50;
        $lines = explode("\n", $text);
        echo "<div class='result'>";
        $page_count = 1;
        echo "<button id='printBtn' onclick='window.print()'>💾 SAVE / PRINT (A4)</button><br><br>";

        while (count($lines) > 0) {
            $current_page_lines = array_splice($lines, 0, $lines_per_page);
            echo "<div class='page'>";
            echo "<h3>📄 পৃষ্ঠা $page_count</h3>";
            echo "<pre>" . htmlspecialchars(implode("\n", $current_page_lines)) . "</pre>";
            echo "</div>";
            $page_count++;
        }
        echo "</div>";
    } else {
        echo "<div class='result'>❌ কোন টেক্সট পাওয়া যায়নি।</div>";
    }
}
?>

</body>
</html>
