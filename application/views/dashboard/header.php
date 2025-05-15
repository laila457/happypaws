<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - HappyPaws</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            color: white;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar a.active {
            color: white;
            background-color: #28a745;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>