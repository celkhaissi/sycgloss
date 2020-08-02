<?php 
$term = $_GET['term'];
$lexeme_json = file_get_contents('lexeme.json');
$lexeme_array = json_decode($lexeme_json,true);
echo "<pre>";
print_r($lexeme_array);

?>