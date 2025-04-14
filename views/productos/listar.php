<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Cursos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  
  <div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="bg-blue-500 text-white p-4">
        <h2 class="text-lg font-semibold">Lista de Cursos</h2>
      </div>
      <div class="p-4">
        <table class="min-w-full divide-y divide-gray-200" id="tabla-cursos">
          <colgroup>
            <col style="width: 4%;">  <!-- ID -->
            <col style="width: 18%;"> <!-- Categoría -->
            <col style="width: 17%;"> <!-- Título -->
            <col style="width: 27%;"> <!-- Duración -->
            <col style="width: 10%;"> <!-- Nivel -->
            <col style="width: 7%;"> <!-- Precio -->
            <col style="width: 7%;"> <!-- Fechas -->
            <col style="width: 10%;"> <!-- Acciones -->
          </colgroup>
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Contenido de forma dinámica -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const tabla = document.querySelector("#tabla-cursos tbody");

    function obtenerDatos(){
      fetch(`../../app/controllers/CursoController.php?task=getAll`, {
        method: 'GET'
      })
        .then(response => { return response.json() })
        .then(data => { 
          tabla.innerHTML = ``;

          data.forEach(element => {
            tabla.innerHTML += `
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">${element.id}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.categoria}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.titulo}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.duracion}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.nivel}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.precio}</td>
              <td class="px-6 py-4 whitespace-nowrap">${element.fechas}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <a href='editar.php?id=${element.id}' title='Editar' class='text-blue-600 hover:text-blue-900'><i class="fa-solid fa-pen"></i></a>
                <a href='#' title='Eliminar' data-idcurso='${element.id}' class='text-red-600 hover:text-red-900 ml-2 delete'><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>
            `;
          });
         })
        .catch(error => { console.error(error) });
    }

    document.addEventListener("DOMContentLoaded", () => {
      obtenerDatos();

      tabla.addEventListener("click", (event) => {
        const enlace = event.target.closest('a');
        
        if (enlace && enlace.classList.contains('delete')){
          event.preventDefault();
          const idcurso = enlace.getAttribute('data-idcurso');
          
          if (confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../app/controllers/CursoController.php/${idcurso}`, { method: 'DELETE' })
              .then(response => { return response.json() })
              .then(datos => { 
                if (datos.filas > 0){
                  const filaEliminar = enlace.closest('tr');
                  if (filaEliminar) { filaEliminar.remove(); }
                }
               })
              .catch(error => { console.error(error) });
          }
        }

      });

    });

  </script>

</body>
</html>