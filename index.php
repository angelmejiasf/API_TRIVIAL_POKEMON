<!DOCTYPE html>
<html>
    <head>
        <?php
        if (isset($_POST["submit"])) {
            $amount = $_POST["amount"];
            $category = $_POST["category"];
            $difficulty = $_POST["difficulty"];

            $request = file_get_contents("https://opentdb.com/api.php?amount=" . $amount . "&category=" . $category . "&difficulty=" . $difficulty);
            $question = json_decode($request, true);
        }
        ?>
        <meta charset="UTF-8">
        <title>Trivial</title>
        <!-- enlace a Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://kit.fontawesome.com/45d72edd49.css" crossorigin="anonymous">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Trivial I.E.S. Ribera del Tajo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/pokemon.php">Juega con Pokemon API</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <h1 class="my-5">Trivial I.E.S. Ribera del Tajo</h1>
            <form method="post">
                <div class="form-group">
                    <label for="amount">Número de preguntas:</label>
                    <input type="number" name="amount" id="amount" class="form-control" min="1" max="50">
                </div>
                <div class="form-group">
                    <label for="category">Categoría:</label>
                    <select name="category" id="category" class="form-control">
                        <?php
                        // Realizar una solicitud HTTP a la API para obtener las categorías
                        $api_url = 'https://opentdb.com/api_category.php';
                        $response = file_get_contents($api_url);
                        $data = json_decode($response, true);

                        // Verificar si la solicitud fue exitosa y si hay datos disponibles
                        if ($data && isset($data['trivia_categories'])) {
                            $categories = $data['trivia_categories'];

                            // Generar las opciones del select con las categorías obtenidas
                            $category_options = '';
                            foreach ($categories as $category) {
                                $category_options .= '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                            }
                        } else {
                            // Manejar el caso en el que no se puedan obtener las categorías
                            $category_options = '<option value="">No se pueden obtener las categorías</option>';
                        }

                        echo $category_options;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="difficulty">Dificultad:</label>
                    <select name="difficulty" id="difficulty" class="form-control">
                        <option value="easy" name="easy">Easy</option>
                        <option value="medium" name="medium">Medium</option>
                        <option value="Hard" name="Hard">Hard</option>

                    </select>
                </div>
                <input type="submit" value="Comenzar" name="submit" class="btn btn-primary my-3">
            </form>
            <?php
            if (isset($question)) {
                foreach ($question['results'] as $questions) {
                    echo '<div>';
                    echo '<p>' . $questions['question'] . '</p>';
                    echo '<ul>';
                    foreach ($questions['incorrect_answers'] as $incorrect_answer) {
                        echo '<li>' . $incorrect_answer . '</li>';
                    }
                    echo '<li>' . $questions['correct_answer'] . '</li>';
                    echo '</ul>';
                    echo '</div>';
                }
            }else{
               
            }
            
            
            ?>
        </div>
        <!-- Footer -->
        <footer class="bg-dark text-center text-white">
            <!-- Grid container -->
            <div class="container p-4">
                <p>Alumno: Ángel Mejías Figueras .Mayo 2024</p>
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
