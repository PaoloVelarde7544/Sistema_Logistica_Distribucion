<?php
require_once '../controllers/CategoriaController.php';

$categoriaController = new CategoriaController();
$categorias = $categoriaController->listAll(); // Obtiene las categorías del controlador
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logística y Distribución</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --background-image-light: url('../images/5082238.jpg');
            --background-image-dark: url('../images/5137894.jpg'); /* Imagen para el modo oscuro */
            --title-color-light: #000;
            --title-color-dark: #fff;
        }

        body {
            background: var(--background-image-light) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 95%;     
            transition: all 0.3s ease-in-out;
        }

        body.dark-mode {
            background: var(--background-image-dark) no-repeat center center fixed;
        }
        .navbar {
            background: linear-gradient(16deg, rgba(30, 126, 52, 0.9), rgba(40, 167, 69, 0.9)); /* Degradado verde semitransparente */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }
        .nav-link {
            font-size: 1rem;
            color: #fff !important;
            margin-right: 15px;
        }
        .nav-link:hover {
            color: #d4edda !important;
        }
        h1 {
            text-align: center;
            font-weight: bold;
            color: #fff; /* Cambia el título a blanco para que contraste con la imagen */
            margin: 30px 0;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Sombra para mejor visibilidad */
        }
        #map {
            height: 500px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            border: 2px solid #28a745;
        }
        footer {
            background: linear-gradient(45deg, rgba(33, 136, 56, 0.9), rgba(40, 167, 69, 0.9)); /* Degradado inverso */
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 30px;
            font-size: 0.9rem;
        }
        footer a {
            color: #d4edda;
            text-decoration: none;
        }
        footer a:hover {
            color: #fff;
        }
        .icon {
            margin-right: 10px;
            color: #fff;
        }
        /* Botones personalizados */
        .btn-custom {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #218838;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
    </style>
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="../images/logo_logis_ok.png" alt="Logo"style="width: 80px; height: auto;">
                <i class="fas fa-truck icon"></i>Logística y Distribución
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../views/categorias.php">
                            <i class="fas fa-boxes icon"></i>Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/centros.php">
                            <i class="fas fa-warehouse icon"></i>Centros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/rutas.php">
                            <i class="fas fa-route icon"></i>Rutas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/usuarios.php">
                            <i class="fas fa-users icon"></i>Usuarios
                        </a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-outline-light ms-3" onclick="toggleDarkMode()">Modo Oscuro</button>

        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <h1 style="color: white; text-shadow: 1px 1px 10px black, -1px -1px 10px black;">
            <i class="fas fa-map-marked-alt"></i> Sistema de Logística y Distribución</h1>
        <div id="map" class="rounded"></div>
    </div>

    <!-- Modal para agregar punto -->
    <div class="modal fade" id="addPointModal" tabindex="-1" aria-labelledby="addPointModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addPointForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPointModalLabel">Agregar Nuevo Punto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <div class="row g-4">
                            <!-- Primera columna -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 shadow-sm" id="nombre" name="nombre" placeholder="Nombre" required>
                                    <label for="nombre" style="color: #555;">Nombre</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <textarea class="form-control border-0 shadow-sm" id="descripcion" name="descripcion" placeholder="Descripción" style="height: 120px;" required></textarea>
                                    <label for="descripcion" style="color: #555;">Descripción</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <select class="form-select border-0 shadow-sm" id="id_categoria" name="id_categoria" required>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= htmlspecialchars($categoria['id_categoria'], ENT_QUOTES, 'UTF-8') ?>">
                                                <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="id_categoria" style="color: #555;">Categoría</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <input type="text" class="form-control border-0 shadow-sm" id="horario_operacion" name="horario_operacion" placeholder="Horario Operación" required>
                                    <label for="horario_operacion" style="color: #555;">Horario Operación</label>
                                </div>
                            </div>
                            
                            <!-- Segunda columna -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control border-0 shadow-sm" id="capacidad" name="capacidad" placeholder="Capacidad" required>
                                    <label for="capacidad" style="color: #555;">Capacidad</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <input type="text" class="form-control border-0 shadow-sm" id="tipos_recursos" name="tipos_recursos" placeholder="Tipos de Recursos" required>
                                    <label for="tipos_recursos" style="color: #555;">Tipos de Recursos</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <input type="text" class="form-control border-0 shadow-sm" id="zona_cobertura" name="zona_cobertura" placeholder="Zona de Cobertura" required>
                                    <label for="zona_cobertura" style="color: #555;">Zona de Cobertura</label>
                                </div>
                                <div class="form-floating mt-3">
                                    <input type="text" class="form-control border-0 shadow-sm" id="contacto" name="contacto" placeholder="Contacto" required>
                                    <label for="contacto" style="color: #555;">Contacto</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="latitud" name="latitud">
                        <input type="hidden" id="longitud" name="longitud">
                    </div>

        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="confirmSave()">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeAndResetForm()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactar con el Mapa -->
    <script>

function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');
        }
        let map, tempMarker;
        let markers = [];

        function initMap() {
            const tarija = { lat: -21.5355, lng: -64.7296 };
            map = new google.maps.Map(document.getElementById("map"), {center: tarija, zoom: 13,});
            loadPoints();

            // Agregar evento de doble clic para agregar nuevos puntos
            map.addListener("dblclick", (event) => {
                if (tempMarker) tempMarker.setMap(null);
                tempMarker = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                });
                document.getElementById("latitud").value = event.latLng.lat();
                document.getElementById("longitud").value = event.latLng.lng();
                const modal = new bootstrap.Modal(document.getElementById("addPointModal"));
                modal.show();
            });

            $('#addPointModal').on('hidden.bs.modal', function () {
                resetFormAndMarker();
            });
        }

        // Función para cargar puntos desde la base de datos y mostrarlos en el mapa
        function loadPoints() {
            $.get('../controllers/CentrosController.php?action=getPoints', function (data) {
                try {
                    clearMarkers(); // Limpiar marcadores existentes
                    const points = JSON.parse(data);

                    points.forEach(function (point) {
                        const marker = new google.maps.Marker({
                            position: { lat: parseFloat(point.latitud), lng: parseFloat(point.longitud) },
                            map: map,
                            title: point.nombre,
                        });
                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                <h5>${point.nombre}</h5>
                                <p><b>Horario:</b> ${point.horario_operacion}</p>
                                <p><b>Capacidad:</b> ${point.capacidad}</p>
                                <p><b>Contacto:</b> ${point.contacto}</p>
                                <p><b>Tipo de recursos:</b> ${point.tipos_recursos || "No especificado"}</p>
                            `,
                        });
                        marker.addListener("click", function () {
                            infoWindow.open(map, marker);
                        });
                        markers.push(marker); // Guardar marcador en el array
                    });
                } catch (error) {
                    console.error("Error al procesar los puntos:", error);
                    alert("Error al cargar los puntos en el mapa.");
                }
            }).fail(function () {
                alert("Error en la conexión con el servidor al cargar puntos.");
            });
        }

        // Función para limpiar marcadores del mapa
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        // Función para limpiar formulario y marcador temporal
        function resetFormAndMarker() {
            $("#addPointForm")[0].reset(); 
            if (tempMarker) {
                tempMarker.setMap(null); 
                tempMarker = null;
            }
        }

        // Función para mostrar la confirmación y manejar "Sí" o "No"
        function confirmSave() {
            if (confirm("¿Estás seguro de que deseas guardar este punto?")) {
                submitForm(); // Guarda el punto
                resetFormAndMarker(); // Limpia y cierra el formulario
            } else {
                alert("El formulario no se ha enviado.");
            }
        }
        
        function submitForm() {
            const formData = $("#addPointForm").serialize(); // Serializar datos del formulario

            $.post("../controllers/CentroLogisticoController.php?action=createFromMap", formData, function (response) {
                try {
                    const res = JSON.parse(response);
                    console.log("Respuesta del servidor:", res);
                    if (res.success) {
                        alert(res.message); 
                        loadPoints(); 
                    } else {
                        alert("Error: " + res.message); 
                    }
                } catch (error) {
                    console.error("Error al procesar la respuesta:", error);  
                }
            }).fail(function () {
                alert("Error en la conexión con el servidor.");
            });
        }

        // Función para limpiar y cerrar el formulario
        function resetFormAndMarker() {
            const modalElement = document.getElementById("addPointModal");
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide(); 
            }
            $("#addPointForm")[0].reset(); 
            if (tempMarker) {
                tempMarker.setMap(null); 
            }
        }

        // Evento para cargar puntos cuando se cierre el modal
        document.getElementById("addPointModal").addEventListener("hidden.bs.modal", function () {
            loadPoints();
        });

        

    </script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3rSjXWyW5t2AP70wNn5KsTsR925e5GGk&callback=initMap" async defer></script>
    
    <!-- Footer -->
    <footer>
        <p>© 2024 Logística y Distribución. Todos los derechos reservados. <a href="#">Política de Privacidad</a></p>
    </footer>
</body>

</html>
