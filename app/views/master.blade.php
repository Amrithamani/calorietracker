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
	
	<nav>
		<ul>
			<li><a href='/list'>List All</a></li>
			<li><a href='/add'>+ Add Book</a></li>
		</ul>
	</nav>
	
    @yield('content')

    

    @yield('body')

</body>
</html>