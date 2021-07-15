<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=@, initial-scale=1.0">
    <link rel="stylesheet" href={{ asset('/css/app.css') }}>
    <title>Document</title>
</head>
<body>
    @include('inc.navbar')
    
    <div class='container'>
        @include('inc.messages')
        @yield('content')
    </div>
</body>
</html>