<?php 
include('header.php');
$file_path = 'tasks.json';
$tasks = [];
$errors = [];

if (file_exists($file_path)) 
{
    $json_content = file_get_contents($file_path);
    $tasks = json_decode($json_content, true);
    if (!is_array($tasks)) 
    {
        $tasks = [];     
    }
}

if (isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];

    if (is_array($tasks)) {
        $tasks = array_filter($tasks, function ($task) use ($delete_id) {
            return isset($task['id']) && $task['id'] !== $delete_id;
        });

        if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
            $success = "Task deleted successfully!";
        } else {
            $errors[] = "Failed to delete the task.";
        }
    }
}
?>
<?php
include('table_of_tasks.php');
include('footer.php');
?>