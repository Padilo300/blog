<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ВСе записи</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/viev/css/style.css">
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col col-12">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link btn btn-primary" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-success" data-toggle="modal" data-target=".addPost" href="#">Добавить запись</a>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <h1 class="text-center">
        Популярные посты
    </h1>
    <div class="container" style="overflow: auto;">
        <div class="row" style="width: 2000px;">
        <?php 
            $bestPost = $posts; // Копия массива с постами

            // сортируем многомерный массив
            function subval_sort($a,$subkey) {
                foreach($a as $k=>$v) {
                    $b[$k] = strtolower($v[$subkey]);
                }
                arsort($b);
                foreach($b as $key=>$val) {
                    $c[] = $a[$key];
                }
                return $c;
            }   
            $bestPost = subval_sort($bestPost, 'contComm');

            foreach ($bestPost as $post): 
            $a=0;
            if($a==5){
                break;
            }
            $a=($a+1);
        ?>
            <div class="col col-12 col-md-2">
                <h3 class="text-center">
                    Cообщение № <?php  echo $post['id']; ?>
                </h3>
                <p  class="alert alert-dark" role="alert" >
                    <?php echo substr($post["content"], 0, 100) . '...'; // обрезаем строку до ста символов ?> 
                </p>
                <p >
                    <?php echo $post['autor'];?>
                    <br>
                    <?php echo $post['date']; ?>
                    <br>
                    Коментариев: <?php echo $post['contComm']; ?>
                </p>
                
                <a class="btn btn-primary" href="/index.php?id=<?php echo $post['id']?>">
                    Подробней
                </a>
                <hr>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <h1 class="text-center">
        Все посты
    </h1>
    <div class="container">
        <div class="row">
       
            <?php foreach ($posts as $post): ?>
            <div class="col col-12">
                <h3 class="text-center">
                    Cообщение № <?php  echo $post['id']; ?>
                </h3>
                <p  class="alert alert-dark" role="alert" >
                    <?php echo substr($post["content"], 0, 100) . '...'; // обрезаем строку до ста символов ?> 
                </p>
                <p >
                    <?php echo $post['autor'];?>
                    <br>
                    <?php echo $post['date']; ?>
                    <br>
                    Коментариев: <?php echo $post['contComm']; ?>
                </p>
               
                <a class="btn btn-primary" href="/index.php?id=<?php echo $post['id']?>">
                    Подробней
                </a>
                <hr>
            </div>
            <?php endforeach; ?>
        </div>
     
    </div>
    <div class="modal fade addPost" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Добавить новую запись</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="addPostForm" action="/controller/addPost.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="autor" class="form-control" id="exampleFormControlInput1" placeholder="Введите ваше имя" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success center-block">
                        Отправить
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>