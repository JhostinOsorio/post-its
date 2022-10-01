<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>New Post Its</title>
</head>
<body>
  <h2>Hola {{ $user->name }}, se ha creado una nueva nota en el grupo que perteneces</h2>
  <hr>
  <main>
    <h2>{{ $note->title }}</h2>
    <p>{{ $note->description }}</p>
    <small>Creado por {{ $note->user->name }}</small>
  </main>
</body>
</html>