<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form class="form" action="/admin/login" method="post">
        @csrf
        <label for="name" class="label">Username:</label>
        <input name="name" id="name" class="input" type="text">
        <label for="password" class="label">Passwort</label>
        <input name="password" id="password" class="input" type="password">
        <div class="guest-code-line"></div>
        <input class="submit" type="submit" value="Send">
    </form>
</body>
</html>