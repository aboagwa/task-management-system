<?php
include('header.php');
include('create-task.php');


if (isset($_POST['submit'])){
    $task_id = uniqid();
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    if (empty($title) || empty($description) || empty($due_date) || empty($status)) {
        $errors['required'] = "Please fill in all fields.";
    } 
    if(strtotime($due_date) < strtotime('now')) {
        $errors['date'] = "Kindly enter a valid date.";
    } 
    if (!preg_match("/^[a-zA-Z\s]+$/", $title))
        $errors['title'] = "Full name should not contain numbers or special characters<br>";

    else {
        $new_task = [
            'id' => $task_id,
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'status' => $status,
        ];
        if(empty($errors)){
        header("location:tasks_table.php");
        $tasks[] = $new_task;

        if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
            $success = "Task added successfully!";
        } else {
            $errors['faild'] = "Failed to save the task.";
        }
    }
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

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    foreach ($tasks as $task) {
        if ($task['id'] === $edit_id) {
            $editing_task = $task;
            break;
        }
    }
}



// if (isset($_POST['edit_task'])) {
//     $task_id = $_POST['task_id'];
//     $updated_title = $_POST['title'];
//     $updated_description = $_POST['description'];
//     $updated_due_date = $_POST['due_date'];
//     $updated_status = $_POST['status'];

//     if (empty($title) || empty($description) || empty($due_date) || empty($status)) {
//         $errors['required'] = "Please fill in all fields.";
//     } elseif (strtotime($due_date) < strtotime('now')) {
//         $errors['date'] = "Kindly enter a valid date.";
//     } elseif (!preg_match("/^[a-zA-Z\s]+$/", $title)) {
//         $errors['title'] = "Title should not contain numbers or special characters.";
//     } else {
//         foreach ($tasks as $task) {
//             if ($task['id'] === $task_id) {
//                 $task['title'] = $title;
//                 $task['description'] = $description;
//                 $task['due_date'] = $due_date;
//                 $task['status'] = $status;
//                 break;
//             }
//         }

//         if (file_put_contents($file_path, json_encode($tasks, JSON_PRETTY_PRINT))) {
//             $success = "Task updated successfully!";
//             $editing_task = null;
//         } else {
//             $errors['failed'] = "Failed to update the task.";
//         }
//     }
// }








?>






<?php 
include('errors_messages.php');
include('submit_form.php');
include('footer.php'); ?>

