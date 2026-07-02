<?php
// Get all image files in the current folder
$files = glob("*.{jpg,JPG,png,PNG}", GLOB_BRACE);

echo "<h2>Image Files in season Folder</h2>";
echo "<ul>";
foreach($files as $file){
    echo "<li>" . htmlspecialchars($file) . "</li>";
}
echo "</ul>";
?>
