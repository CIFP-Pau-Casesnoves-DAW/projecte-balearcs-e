<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missatge de "Contacta amb nosaltres" de {{$nom}}</title>
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
                        <p class="text-center">Nom: {{$nom}}</p>
                        <p class="text-center">Llinatges: {{$llinatges}}</p>
                        <p class="text-center">Mail: {{$mail}}</p>
                        <p class="text-center">Missatge: {{$missatge}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>