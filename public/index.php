<?php
require_once '../controllers/CategoriaController.php';

$categoriaController = new CategoriaController();
$categorias = $categoriaController->listAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logística y Distribución</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3rSjXWyW5t2AP70wNn5KsTsR925e5GGk&callback=initMap" async defer></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: url('../images/5082238.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: linear-gradient(16deg, rgba(30, 126, 52, 0.9), rgba(40, 167, 69, 0.9));
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }

        h1 {
            text-align: center;
            font-weight: bold;
            color: #fff;
            margin: 30px 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        #map {
            height: 500px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            border: 2px solid #28a745;
        }

        .modal-header {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-truck icon"></i> Logística y Distribución
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <h1><i class="fas fa-map-marked-alt"></i> Sistema de Logística y Distribución</h1>
        <div id="map" class="rounded"></div>
        <div class="text-center mt-4">
            <button class="btn btn-success btn-custom" id="addPointButton"><i class="fas fa-plus-circle"></i> Agregar Punto</button>
        </div>
    </div>

    <div class="modal fade" id="pointModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Ingresar Datos del Punto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pointForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select id="categoria" class="form-select" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= htmlspecialchars($categoria['id_categoria'], ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="horario" class="form-label">Horario Operación</label>
                            <input type="text" id="horario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" id="capacidad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="recursos" class="form-label">Tipos de Recursos</label>
                            <input type="text" id="recursos" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="zona" class="form-label">Zona de Cobertura</label>
                            <input type="text" id="zona" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Contacto</label>
                            <input type="text" id="contacto" class="form-control" required>
                        </div>
                        <div class="d-none">
                            <input type="text" id="longitud">
                            <input type="text" id="latitud">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100">Guardar</button>
                            <button type="button" class="btn btn-secondary w-100 mt-2" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <p>© 2024 Logística y Distribución. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let map, selectedPosition = null;

        function initMap() {
            const tarija = { lat: -21.5355, lng: -64.7296 };

            map = new google.maps.Map(document.getElementById("map"), {
                center: tarija,
                zoom: 13,
            });

            map.addListener("dblclick", (event) => {
                selectedPosition = event.latLng;
                document.getElementById("longitud").value = selectedPosition.lng();
                document.getElementById("latitud").value = selectedPosition.lat();
                new bootstrap.Modal(document.getElementById("pointModal")).show();
            });
        }

        document.getElementById("addPointButton").addEventListener("click", () => {
            map.panTo({ lat: -21.5355, lng: -64.7296 });
            map.setZoom(13);
        });

        document.getElementById("pointForm").addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Punto guardado con éxito!");
        });
    </script>
</body>

</html>
