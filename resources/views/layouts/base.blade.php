<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../resources/css/app.css" rel="stylesheet">
        <link href="../resources/css/bootstrap-datepicker3.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="../resources/js/app.js"></script>
        <script src="../resources/js/bootstrap-datepicker.min.js"></script>
        <script src="../resources/js/bootstrap-datepicker.ru.min.js"></script>
        <title>@yield('title') :: Список задач</title>
    </head>
    <body class="index">
        <nav class="navbar navbar-expand-lg navbar-light bg-light top-bar">
        <div class="container-fluid">
        <a type="button" class="btn btn-primary" id="btnAddTask">Добавить задачу</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Сортировать по
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('index') }}">Дате добавления</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['sort_by' => 'user']) }}">Пользователю</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['sort_by' => 'status']) }}">Статусу</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['sort_by' => 'deadline']) }}">Сроку</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['sort_by' => 'date_done']) }}">Дате выполнения</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
        </nav>
        <div class="container">
            @yield('main')
        </div>
    </body>
</html>
