<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Escaleras y Serpientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            width: 40px;
            height: 40px;
            border: 1px solid black;
            text-align: center;
            position: relative;
        }

        .container-1 {
            border: 1px solid black;
            padding: 20px;
            width: 300px;
            margin: auto;
            text-align: center;
        }

        .ficha-roja-container {
            width: 40px;
            height: 40px;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .ficha-roja {
            width: 100%;
            height: 100%;
            background-color: red;
            border-radius: 50%;
        }

        .tablero-container {
            position: relative;
        }

        .ficha-roja-container {
            z-index: 1;
            bottom: 360px; /* Inicia en la posición 1,1 */
            left: 0;
        }

        /* Agregamos estilos para los colores */
        .azul {
            background-color: blue;
        }

        .verde {
            background-color: green;
        }

        .blanco {
            background-color: white;
        }

        .anaranjado {
            background-color: orange;
        }

        .amarillo {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-6">
            <h2>Bienvenido</h2>
            <?php
            // Definir una variable para almacenar el nombre del jugador
            $jugador1 = '';

            // Verificar si se ha enviado el formulario y asignar el nombre del jugador
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $jugador1 = $_POST['jugador1'];
                echo "<p>Hola, $jugador1. ¡Bienvenido al juego!</p>";
            }
            ?>

            <div class="container-1">
                <h2>Generador de Números</h2>
                <?php
                function generarNumeroAleatorio()
                {
                    return rand(1, 12);
                }

                // Inicializar el contador si no está establecido
                if (!isset($_POST['contador'])) {
                    $_POST['contador'] = 0;
                }

                // Función para mostrar el resultado
                function mostrarResultado()
                {
                    global $jugador1; // Hacer la variable $jugador1 global

                    $numeroAleatorio = generarNumeroAleatorio();
                    $_POST['contador'] += $numeroAleatorio;

                    echo "<p>Número generado: $numeroAleatorio</p>";
                    echo "<p>Total acumulado: {$_POST['contador']}</p>";

                    if ($_POST['contador'] >= 100) {
                        echo "<p>¡GANASTE, $jugador1!</p>";
                        // Reiniciar el contador
                        $_POST['contador'] = 0;
                    }
                }

                // Si se ha presionado el botón "INICIAR", llamar a la función mostrarResultado
                if (isset($_POST['iniciar'])) {
                    mostrarResultado();
                }
                ?>

                <!-- Formulario con el botón "INICIAR" y el contador oculto -->
                <form method="post" action="">
                    <input type="hidden" name="contador" value="<?php echo $_POST['contador']; ?>">
                    <!-- Campo oculto para mantener el nombre del jugador -->
                    <input type="hidden" name="jugador1" value="<?php echo $jugador1; ?>">
                    <input type="submit" name="iniciar" value="INICIAR">
                </form>

                <!-- Botón para reiniciar -->
                <form method="post" action="">
                    <input type="submit" name="reiniciar" value="REINICIAR">
                </form>
            </div>
        </div>
        <div class="col-6">
            <h2>Tablero</h2>
            <div class="container">
                
                <div class="tablero-container">
                    <table class="tablero">
                        <?php
                        function generarNumeros()
                        {
                            $numeros = [];
                            $inicio = 100;
                            for ($fila = 0; $fila < 10; $fila++) {
                                $fila_numeros = [];
                                if ($fila % 2 == 0) {
                                    // Fila ascendente
                                    for ($j = 0; $j < 10; $j++) {
                                        $fila_numeros[] = $inicio--;
                                    }
                                } else {
                                    // Fila descendente
                                    $inicio -= 9;
                                    for ($j = 0; $j < 10; $j++) {
                                        $fila_numeros[] = $inicio++;
                                    }
                                    $inicio -= 11;
                                }
                                $numeros = array_merge($numeros, $fila_numeros);
                            }
                            return $numeros;
                        }

                        $numeros = generarNumeros();
                        $indice = 0;
                        for ($i = 0; $i < 10; $i++) {
                            echo "<tr>";
                            for ($j = 0; $j < 10; $j++) {
                                $numero = $numeros[$indice++];
                                // Agregamos clases de colores aleatorios a los cuadros
                                $color = ['azul', 'verde', 'blanco', 'anaranjado', 'amarillo'][rand(0, 4)];
                                echo "<td class='$color'>$numero</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <!-- Ficha roja -->
                    <div class="ficha-roja-container" style="bottom: <?php echo (9 - floor($_POST['contador'] / 10)) * 40; ?>px; left: <?php echo ($_POST['contador'] % 10) * 40; ?>px;">
                        <div class="ficha-roja"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
