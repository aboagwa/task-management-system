# Task Management System

# Task Management System

## Description
This is a simple Task Management System built using PHP. It allows users to add, view, edit, and delete tasks. The tasks are stored in a JSON file (`tasks.json`), serving as a lightweight database.

## Features
- Add new tasks with a title and description.
- View a list of all tasks.
- Edit existing tasks.
- Delete tasks.
- Tasks are stored in a JSON file for persistence.

## Technologies Used
- PHP
- HTML
- CSS (Bootstrap for styling)
- JSON (for data storage)

## Installation & Setup
1. Download or clone the repository.
2. Ensure you have a local PHP environment (XAMPP, MAMP, or a built-in PHP server).
3. Place the project files in your web server's root directory.
4. Start your local server and access the project in your browser.

## Usage
1. Open the application in your browser.
2. Use the task form to add new tasks.
3. View, edit, or delete tasks as needed.

## File Structure
```
/task-management-system
│── index.php          # Main task management file
│── create-task.php    # Handles task creation
│── tasks_table.php    # Displays task list
│── tasks.json         # Stores tasks in JSON format
│── header.php         # Includes Bootstrap and common header elements
│── style.css          # (Optional) CSS for UI styling
```

## JSON Data Structure
```json
[
  {
    "id": "1",
    "title": "Example Task",
    "description": "This is a sample task.",
    "status": "Pending"
  }
]
```

## Future Enhancements
- Implement user authentication.
- Store tasks in a MySQL database instead of JSON.
- Add task categories and priorities.
- Introduce search and filtering features.

## Author
## Mohamed Hassan