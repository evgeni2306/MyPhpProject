<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/pageAndEditor.css"/>
    <title>Моя страница</title>
</head>
<body>
<main>
<?require 'html/header.html'?>
    <div class='user-interface'>
        <img class='avatar' src='/images/{{$_SESSION['avatar']}}' alt=''>
        <div class='user-information'>
            <h1>{{$_SESSION['name'] . ' ' . $_SESSION['surname']}}</h1>
            <h2>День рождения: {{$_SESSION['birthday']}}</h2>
            <h2>Город: {{ $_SESSION['city']}}</h2>
        </div>
        <button class='edit'><a style=' text-decoration: none; ' href="pageEditor">Редактировать</a></button>
        <form action="{{route('user.private')}}" class='addcomment' method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" class='inptcomment' name="Text" placeholder="Написать комментарий"/>
            <button class='addcommentbutton' type="submit">Опубликовать</button>
        </form>


    </div>

    <section>
        <ol class='commentslist'>
            <? foreach ($_SESSION['Posts'] as $post ) { ?>
            <li>{{$post->name.' '.$post->surname. '   : '.$post->Text}}</li>

            <? }?>
        </ol>
    </section>
</main>
</body>
</html>
