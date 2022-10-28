<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1248/1248750.png?w=740&t=st=1666742099~exp=1666742699~hmac=aaa4d5478cdce6bc320f89624cf4aa462161910265b73796432275b117dbac13">
    <title>Prueba Técnica | Jeniffer Flores</title>
    @include('tech.template.global_css')
    @stack('style')

</head>
<body>
@yield('content')
@routes
@include('tech.template.global_js')
@stack('scripts')

</body>
</html>
