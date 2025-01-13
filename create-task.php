<?php
$file_path = 'tasks.json';
$tasks = [];
$errors = [];
$success = null;
$editing_task = [];


if (file_exists($file_path)) 
{
    $json_content = file_get_contents($file_path);
    $tasks = json_decode($json_content, true);
    if (!is_array($tasks)) 
    {
        $tasks = [];     
    }
}




?>
