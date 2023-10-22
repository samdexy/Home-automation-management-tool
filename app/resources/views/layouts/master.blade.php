<!DOCTYPE html>
<html lang="en">
<head>
    <title>Plug App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="{{ mix("css/app.css") }}" rel="stylesheet"/>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/6.3.3/firebase-app.js"></script>
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

    <script src="{{ mix("js/app.js") }}" defer></script>
             <!-- include VueJS first -->
        <script src="https://unpkg.com/vue@latest"></script>

        <!-- use the latest vue-select release -->
        <script src="https://unpkg.com/vue-select@latest"></script>
        <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">

        <!-- or point to a specific vue-select release -->
        <script src="https://unpkg.com/vue-select@3.0.0"></script>
        <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue-apexcharts"></script>
        <script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>


        <script type="text/javascript">
            window.auth_user = {!! json_encode($auth_user); !!};
            localStorage.setItem('auth_user', JSON.stringify(window.auth_user))
        </script>

</head>
<body class="font-sans bg-lightgrey">
    @yield('content')

</body>
</html>
