<?php
// Define arrays for each season (adjust prefixes if needed)
$seasons = [
    'summer' => ['shirt', 'short', 'skirt'],
    'winter' => ['winter', 'd'],
    'spring' => ['spring', 'floral', 'c'],
    'autumn' => ['autumn', 'a']
];

foreach($seasons as $season => $prefixes){
    echo "<h2>".ucfirst($season)."</h2><ul>";
    
    foreach(glob("*.{jpg,JPG,png,PNG}", GLOB_BRACE) as $file){
        foreach($prefixes as $prefix){
            if(stripos($file, $prefix) === 0){
                echo "<li>".$file."</li>";
            }
        }
    }
    
    echo "</ul>";
}
?>
