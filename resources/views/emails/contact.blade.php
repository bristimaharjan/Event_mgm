<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Contact Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .card {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            padding: 30px;
            border: 1px solid #ddd;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 12px 24px rgba(0,0,0,0.3);
            transform: translateY(-2px);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            background-color: #8D85EC;
            color: white;
            font-size: 1.8em;
            padding: 10px;
            border-radius: 8px;
        }
        .info {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }
        .value {
            display: inline-block;
            margin-left: 8px;
        }
        .message {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            white-space: pre-wrap; /* preserves formatting */
            margin-top: 10px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>New Inquiry</h1>
        <div class="info"><span class="label">Name:</span><span class="value">{{ $name }}</span></div>
        <div class="info"><span class="label">Email:</span><span class="value">{{ $email }}</span></div>
        <div class="info"><span class="label">Message:</span></div>
        <div class="message">{{ $bodymessage }}</div>
    </div>
</body>
</html>