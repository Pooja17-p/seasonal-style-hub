<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: /SeasonalStyleHub/season/index.php");
exit();
