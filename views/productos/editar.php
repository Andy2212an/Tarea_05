<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Curso</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  
  <div class="container mx-auto p-4">

    <form action="" autocomplete="off" id="formulario-registro" class="max-w-lg mx-auto">
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-500 text-white p-4">
          <h2 class="text-lg font-semibold">Actualizar datos del curso</h2>
        </div>
        <div class="p-4">
          
          <div class="mb-4">
            <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
            <select name="categoria" id="categoria" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
              <option value="">Seleccione</option>
              <option value="1">Matemáticas</option>
              <option value="2">Literatura</option>
              <option value="3">Informática</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
            <input type="text" class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="titulo" placeholder="Título del curso" required>
          </div>

          <div class="mb-4">
            <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (en meses)</label>
            <input type="number" class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="duracion" placeholder="Duración del curso" required>
          </div>

          <div class="mb-4">
            <label for="nivel" class="block text-sm font-medium text-gray-700">Nivel</label>
            <select name="nivel" id="nivel" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
              <option value="Básico">Básico</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
            <input type="number" class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="precio" placeholder="Precio del curso" required>
          </div>

          <div class="mb-4">
            <label for="fechas" class="block text-sm font-medium text-gray-700">Fechas</label>
            <input type="text" class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="fechas" placeholder="Fechas del curso" required>
          </div>

        </div>
        <div class="bg-gray-50 p-4 text-right">
          <button class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm" type="submit">Actualizar</button>
          <button class="bg-gray-500 text-white px-4 py-2 rounded-md text-sm" type="reset">Cancelar</button>
        </div>
      </div>
    </form>

  </div>

  <script>
    // Initialize Flatpickr for date input
    flatpickr("#fechas", {
      mode: "range",
      dateFormat: "Y-m-d",
      minDate: "today"
    });

    document.addEventListener("DOMContentLoaded", () => {
      
      function obtenerRegistro(){
        const URL = new URLSearchParams(window.location.search);
        const idcurso = URL.get('id');

        const parametros = new URLSearchParams();
        parametros.append("task", "getById");
        parametros.append("idcurso", idcurso);

        fetch(`../../app/controllers/CursoController.php?${parametros}` , { method: 'GET' })
          .then(response => { return response.json() })
          .then(data => { 
            document.querySelector("#categoria").value = data.idcategoria;
            document.querySelector("#titulo").value = data.titulo;
            document.querySelector("#duracion").value = data.duracion;
            document.querySelector("#nivel").value = data.nivel;
            document.querySelector("#precio").value = data.precio;
            document.querySelector("#fechas").value = data.fechas;
          })
          .catch(error => { console.error(error) });
      }

      obtenerRegistro();

      const formulario = document.querySelector("#formulario-registro");

      function actualizarCurso(){
        const URL = new URLSearchParams(window.location.search);
        const idcurso = URL.get('id');

        fetch(`../../app/controllers/CursoController.php`, {
          method: 'PUT',
          headers: {'Content-Type' : 'application/json'},
          body: JSON.stringify({
            idcurso     : idcurso,
            idcategoria : document.querySelector("#categoria").value,
            titulo      : document.querySelector("#titulo").value,
            duracion    : parseInt(document.querySelector("#duracion").value),
            nivel       : document.querySelector("#nivel").value,
            precio      : parseFloat(document.querySelector("#precio").value),
            fechas      : document.querySelector("#fechas").value
          })
        })
          .then(response => { return response.json() })
          .then(data => { 
            if (data.filas > 0){
              alert("Actualizado correctamente"); //TEMPORAL
              window.location.href = "listar.php"; // Redirigir a listar.php después de actualizar
            }
           })
          .catch(error => { console.error(error) });
      }

      formulario.addEventListener("submit", function (event){
        event.preventDefault(); //cancela el evento

        if (confirm("¿Está seguro de actualizar?")){
          actualizarCurso();
        }
      });

    });
  </script>

</body>
</html>