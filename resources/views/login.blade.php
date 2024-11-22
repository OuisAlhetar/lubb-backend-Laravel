<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body class="antialiased">
  <form action="/login">
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email">
    </div>
    <div>
      <label for="password">username</label>
      <input type="password" id="password" name="password">
    </div>
    <button type="submit">login</button>
  </form>
  <a href={{"auth/google"}}>login with google</a>
</body>

</html>