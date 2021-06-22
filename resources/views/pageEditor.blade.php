<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/pageAndEditor.css"/>
    <title>Редактирование моей страницы</title>
</head>
<body>
<main>
    <?require 'html/header.html'?>
    <div class='user-interface'>
        <form action="{{route('user.pageEditor')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3 style='margin-left:250px;'>Редактирование профиля</h3><br>
            <input value='' class='inpttext' type='text' name='name' placeholder="Введите имя"/><br>
            <input value='' class='inpttext' type='text' name='surname' placeholder="Введите фамилию"><br>
            <input value='' class='inpttext' type='date' name='birthday' placeholder="Укажите дату рождения"><br>
            <input value='' class='inpttext' type='text' name='city' placeholder="Укажите город"><br>
            <input type="file" name="photo" class="inpttext"/><br/>
            <input class='inpttext' type='submit' value='Сохранить'>
        </form>
    </div>
</main>
</body>
</html>
