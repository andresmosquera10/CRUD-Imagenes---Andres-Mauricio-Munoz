 <?php
    require_once 'conexion/db.php';
    session_start();

    $mensaje = "";
    if (!empty($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
    }

    if (isset($_POST['btneditar'])) {
        $mensaje = require 'controlador/editar.php';
    }

    $sql = "SELECT * FROM imagenes ORDER BY id ASC";
    $resultado = $db->query($sql);
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>CRUD de imágenes</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
 </head>

 <body>

     <h1 class="text-center font-weight-bold p-4">CRUD de imágenes - Andrés Muñoz</h1>

     <div class="p-3 table-responsive">
         <!-- Button trigger modal -->
         <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
             Insertar imagen
         </button>

         <!-- Modal -->
         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h1 class="modal-title fs-5" id="exampleModalLabel">Enviar imagen</h1>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <form action="index.php" enctype="multipart/form-data" method="post">
                             <input type="file" class="form-control mb-2" name="imagen">
                             <input type="submit" value="Enviar" name="btnenviar" class="form-control btn btn-success mt-2">
                         </form>
                     </div>
                 </div>
             </div>
         </div>

         <?php if (!empty($mensaje)) : ?>
             <div class="alert alert-info">
                 <?= $mensaje ?>
             </div>
         <?php endif; ?>

         <table class="table table-dark table-striped-columns">

             <thead class="bg-dark text-white">
                 <tr>
                     <th scope="col">ID</th>
                     <th scope="col">Imagen</th>
                     <th scope="col">Acciones</th>
                 </tr>
             </thead>
             <tbody>
                 <?php while ($datos = $resultado->fetch(PDO::FETCH_OBJ)) { ?>
                     <tr>
                         <th scope="row"><?= $datos->id ?></th>
                         <td>
                             <img src="<?= $datos->ruta ?>?v=<?= time() ?>" alt="Imagen" <?= $datos->nombre ?>"
                                 class="img-thumbnail" style="width: 100px; height: 100px;">
                         </td>
                         <td>
                             <a href="#" class="btn btn-warning"
                                 data-bs-toggle="modal"
                                 data-bs-target="#exampleModalEditar<?= $datos->id ?>">
                                 Editar
                             </a>

                             <!-- Botón eliminar -->
                             <a href="controlador/eliminar.php?id=<?= $datos->id ?>"
                                 class="btn btn-danger btn-sm"
                                 onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?');">
                                 Eliminar
                             </a>
                         </td>
                     </tr>

                     <!-- Modal editar -->
                     <div class="modal fade" id="exampleModalEditar<?= $datos->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h1 class="modal-title fs-5" id="exampleModalLabel">Editar imagen</h1>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                     <form action="index.php" enctype="multipart/form-data" method="post">
                                         <input type="hidden" name="id" value="<?= $datos->id ?>">
                                         <input type="hidden" name="nombre" value="<?= $datos->id ?>">
                                         <input type="file" class="form-control mb-2" name="imagen">
                                         <input type="submit" value="Actualizar" name="btneditar" class="form-control btn btn-success mt-2">
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>

                 <?php } ?>
             </tbody>
         </table>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
 </body>

 </html>
 <?php
    $db = null;
    ?>