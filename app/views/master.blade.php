<!DOCTYPE html>
<html>
<head>

    <title>@yield('title', 'Calorie Tracker')</title>

    <meta charset='utf-8'>
    <link rel='stylesheet' href='/css/calorie.css' type='text/css'>

    @yield('head')

</head>
<body>

	<img src='images/calorieCalculator.jpg' alt='Calorietracker>
	
    @yield('content')

    

    @yield('body')

</body>
</html>