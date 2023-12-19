<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Edita Usuari</title>
</head>

<body>

    <div class="container mt-5">
        <h2><a href="{{route('usuari.index')}}">Editorials</a></h2>

        <form method='post' action="{{route('usuari.update',$usuari->id)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="codi">Codi:</label>
                <input type="text" class="form-control" id="codi" name="id" value="{{ $usuari->id }}" readonly>
            </div>

            <div class="form-group">
                <label for="nom_usuari">Nom Usuari:</label>
                <input type="text" class="form-control" id="nom_usuari" name="NOM_USUARI" value="{{ $usuari->nom }}" placeholder="Introdueix el Nom Usuari" required>
            </div>

            <button type="submit" class="btn btn-primary" name="GUARDAR">Guardar</button>
            <!-- <button type="submit" class="btn btn-danger" name="ESBORRAR">Esborrar</button> -->
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>