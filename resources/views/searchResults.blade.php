<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/searchAndResults.css"/>
    <title>Поиск</title>
</head>
<body>
<main>
    <?require 'html/header.html'?>
    <div class='user-interface'>
        <div class="inptsearch">
            <form class="form" action="{{route('user.search')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input value='' class='form-input' type='text' name='name' placeholder="Введите имя"/>
                <input value='' class='form-input' type='text' name='surname' placeholder="Введите фамилию"/>
                <input class='form-button' type='submit' value='Найти'>
            </form>
        </div>
        <div class="result">

            <section>
                <ol class="result-list">
                    <? foreach ($_SESSION['searchUsers'] as $user ) { ?>
                    <li>
                        <div class="user-result">
                            <img class='avatar' src='images/{{$user->photo}}' alt=''>
                            <div class="name-surname"><a href='id={{$user->id}}'>{{$user->name.' '.$user->surname}}</a>
                            </div>
                            <div class="city">{{$user->city}}</div>
                        </div>
                    </li>
                    <? } ?>


                </ol>
            </section>
        </div>

    </div>
</main>
</body>
</html>
