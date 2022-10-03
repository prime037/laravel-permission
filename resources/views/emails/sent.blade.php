<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
</head>
<body>
    <h1>Data Added!</h1>
    <h2>Data Specification</h2>
    <ul>
        <li>
            Name Product : {{$data['name']}}
        </li>
        <li>
            Amount : {{$data['jumlah']}}
        </li>
    </ul>
</body>
</html>