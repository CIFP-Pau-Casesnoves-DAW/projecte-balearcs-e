<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>Mostra Usuaris</title>
</head>

<body>
    <div class="container">
        <div class="w-50">
            <table class='table table-sm table-striped'>
                <thead>
                    <tr>
                        <th>Codi</th>
                        <th>Usuari</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                @foreach ($usuaris as $usuari)
                <tr>
                    <td scope="col">
                        {{ $usuari->id }}
                    </td>
                    <td scope="col">
                        {{ $usuari->nom }}
                    </td>
                    <td scope="col">
                        <a href="{{route('usuari.show',$usuari->id)}}" class="btn btn-primary btn-sm">Editar</a>
                    </td>
                    <!-- <td scope="col">
                        <form action="" method="post">
                            <button type="submit" class="btn btn-danger btn-sm">Esborrar</button>
                        </form>
                    </td> -->
                </tr>
                @endforeach
            </table>
            {{ $usuaris->links() }}
        </div>
    </div>
</body>