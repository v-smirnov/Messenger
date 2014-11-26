
<div class="jumbotron">
    <?php if ((isset($error_msg)) && ($error_msg!= '')): ?>
        <p class="bg-danger"><?= $error_msg ?></p>
    <?php endif; ?>

    <?php if ((isset($success_msg)) && ($success_msg!= '')): ?>
        <p class="bg-success"><?= $success_msg ?></p>
    <?php endif; ?>

    <form class="form-group" action="index.php?act=Send" method="post"  enctype="multipart/form-data">
        <b>Название:</b><br>
        <input class="form-control" type="text" size="100" name="title"  required autofocus><br><br>
        <b>Текст сообщения:</b><br>
        <textarea class="form-control" cols = "100" rows = "5" name="content"  maxlength="200" required oninput="showNumberOfSymbolsLeft();"></textarea><br>
        <div id="symbolsLeftInfo"></div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
    <!--оставил скрипт для отображения количества оставшихся символов здесь -->
    <script>
        function showNumberOfSymbolsLeft(){
            var messageLength = document.getElementsByName('content')[0].value.length;
            var infoElement = document.getElementById('symbolsLeftInfo');
            infoElement.innerHTML = 'Осталось символов: ' + (200 - messageLength);
        }

        showNumberOfSymbolsLeft();

    </script>
</div>