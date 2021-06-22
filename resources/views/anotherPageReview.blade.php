<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/pageAndEditor.css"/>

    <title>Главная страница</title>
</head>
<body>
<main>
    <?require 'html/header.html'?>
    <div class='user-interface'>
        <img class='avatar' src='/images/{{$_SESSION['anotherAvatar']}}' alt=''>
        <div class='user-information'>
            <h1>{{$_SESSION['anotherName'] . ' ' . $_SESSION['anotherSurname']}}</h1>
            <h2>День рождения: {{$_SESSION['anotherBirthday']}}</h2>
            <h2>Город: {{$_SESSION['anotherCity']}}</h2>
        </div>
        <button class='edit'><a style=' text-decoration: none; ' href="changeType">
            <?if($_SESSION['anotherType']=='2'){ ?>
                Разблокировать <?}else{ ?>
                Заблокировать<? } ?>

            </a></button>
    </div>

    <section>
        <ol class='commentslist'>
            <? foreach ($_SESSION['anotherPosts'] as $post ) { ?>
            <li> {{$post->name.' '.$post->surname. '   : '.$post->Text}}</li>

            <? }?>
        </ol>

    </section>

</main>
</body>
</html>

