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
                                <input type="number" name="limit" min="1" max="40" value="<?php echo isset($_POST['limit']) ? $_POST['limit'] : '20'; ?>">

                                <button type="submit" class="btn btn-primary" name="actualizarLista">Actualizar lista</button>
                            </div>
                            <select class='form-control' id='pokemon' name='pokemon'>
                                <?php
                                $selected_pokemon = isset($_POST['pokemon']) ? $_POST['pokemon'] : ''; // Obtener el Pokémon seleccionado
                                if (isset($_POST['actualizarLista']) || isset($_POST['cargarDatos'])) {
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
                                            // Verificar si este es el Pokémon seleccionado
                                            $selected = ($selected_pokemon == $poke['name']) ? 'selected' : '';
                                            echo '<option value="' . $poke['name'] . '" ' . $selected . '>' . $poke['name'] . '</option>';
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
                            if (isset($pokemon_data['abilities'][0])) {
                                $ability = $pokemon_data['abilities'][0];
                                echo "<h3>Primera habilidad de " . ucfirst($selected_pokemon) . ":</h3>";
                                echo "<p>";
                                echo "Nombre: " . ucfirst($ability['ability']['name']) . "<br>";

                                // Obtener detalles de la habilidad desde su URL
                                $ability_response = file_get_contents($ability['ability']['url']);
                                $ability_data = json_decode($ability_response, true);

                                // Buscar el efecto en inglés dentro de effect_entries
                                $effect = "";
                                foreach ($ability_data['effect_entries'] as $entry) {

                                    if ($entry['language']['name'] == 'en') {
                                        $effect = $entry['effect'];
                                        break;
                                    }
                                }

                                // Imprimir detalles de la habilidad
                                echo "Efecto: " . $effect . "<br>";

                                echo "<img src='" . $pokemon_data['sprites']['back_default'] . "' alt='Imagen de " . ucfirst($selected_pokemon) . "'><br>";
                                echo "</p>";
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