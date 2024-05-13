<!DOCTYPE html>
<html>
    <head>
        <title>Pokémon</title>
        <!-- Link to Bootstrap CSS -->
        <link rel="stylesheet" href="../css/styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://kit.fontawesome.com/45d72edd49.css" crossorigin="anonymous">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Pokémon I.E.S. Ribera del Tajo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Juega al Trivial</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="contenedor">
            <h1>Pokémon</h1>
            <div class="row">
                <div class="col-md-6">         
                    <form method="post">
                        <div class="form-group">
                            <div class="Actualizar">
                                <label for="pokemon">Número de Pokémons a cargar:</label>
                                <input type="number" name="limit" min="1" max="40" value="20">
                                <button type="submit" class="btn btn-primary" name="actualizarLista">Actualizar lista</button>
                            </div>
                            <select class='form-control' id='pokemon' name='pokemon'>
                                <?php
                                if (isset($_POST['actualizarLista'])) {
                                    $amount = $_POST['limit'];
                                    // Realizar una solicitud HTTP a la API para obtener los pokemons
                                    $api_url = 'https://pokeapi.co/api/v2/pokemon/?limit=' . $amount;
                                    $response = file_get_contents($api_url);
                                    $data = json_decode($response, true);

                                    // Verificar si la solicitud fue exitosa y si hay datos disponibles
                                    if ($data && isset($data['results'])) {
                                        $pokemons = $data['results'];

                                        // Generar las opciones del select con los pokemons obtenidos
                                        foreach ($pokemons as $poke) {
                                            echo '<option value="' . $poke['name'] . '">' . $poke['name'] . '</option>';
                                        }
                                    } else {
                                        // Manejar el caso en el que no se puedan obtener los pokemons
                                        echo '<option value="">No se pueden obtener los pokemons</option>';
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary botonCargar" name="cargarDatos">Cargar datos del Pokemon</button>
                    </form>

                    <?php
                    if (isset($_POST['cargarDatos'])) {
                        $selected_pokemon = $_POST['pokemon'];
                        
                        $api_url = 'https://pokeapi.co/api/v2/pokemon/' . $selected_pokemon;
                        $response = file_get_contents($api_url);
                        $pokemon_data = json_decode($response, true);

                        // Verificar si la solicitud fue exitosa y si hay datos disponibles
                        if ($pokemon_data) {
                            // Imprimir los datos del Pokémon
                            echo "<h2>Datos de " . ucfirst($selected_pokemon) . "</h2>";
                            echo "<p><strong>Nombre:</strong> " . ucfirst($selected_pokemon) . "</p>";

                            // Imprimir las habilidades del Pokémon
                            if (isset($pokemon_data['abilities'])) {
                                echo "<h3>Habilidades:</h3>";
                                echo "<ul>";
                                foreach ($pokemon_data['abilities'] as $ability) {
                                    echo "<li>";
                                    echo ucfirst($ability['ability']['name']) . ": ";

                                    // Obtener detalles de la habilidad desde su URL
                                    $ability_response = file_get_contents($ability['ability']['url']);
                                    $ability_data = json_decode($ability_response, true);

                                    // Imprimir detalles de la habilidad
                                    echo $ability_data['effect_entries'][0]['short_effect'];
                                    echo "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "No se encontraron habilidades para este Pokémon.";
                            }
                        } else {
                            
                            echo "No se pueden obtener los datos del Pokémon seleccionado";
                        }
                    }
                    ?>


                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-dark text-center text-white">
            <!-- Grid container -->
            <div class="container p-4">
                <p>Alumno: Ángel Mejías Figueras. Mayo 2024</p>
            </div>
            <!-- Grid container -->
            <!-- Footer Text -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2024 All rights reserved.
            </div>
            <!-- Footer Text -->
        </footer>
    </body>
</html>