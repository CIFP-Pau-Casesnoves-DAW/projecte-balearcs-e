<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmació registre</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Balearcs DAW Pau Casesnoves</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Benvingut {{$nom}} a la missatgeria.</p>
                        <p class="text-center">Per a confirmar el teu registre segueix el següent link</p>
                        <div class="text-center">
                            <a href="{{$link}}" class="btn btn-primary">Confirmar registre</a>
                        </div>
                        <p class="text-center mt-3">Si no has sol·licitat el registre, ignora aquest email.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>