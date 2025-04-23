<!-- components/base.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #e9e9e9;
            overflow: hidden;
        }
        .content {
            padding: 30px;
        }
        .footer {
            padding-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #242EE9;
        }

        a{
            white-space: nowrap;
            color: #242EE9 !important;
        }

        h3{
            margin-bottom: 0 !important;
            margin-top: 10px !important;
        }
    </style>
</head>
<body>
    <div class="email-container">
        {{ $slot }}
    </div>
</body>
</html>