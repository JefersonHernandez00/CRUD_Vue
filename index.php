<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CRUD de Mantenimiento</title>
    <!-- Agregar hoja de estilo bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <!-- Agregar encabezado de página -->
    <header class="navbar navbar-expand-lg navbar-light bg-light">
        <h1>CRUD de Mantenimiento</h1>
    </header>
    <div id="app">
        <div class="container">
            <!-- Mostrar mensaje de alerta cuando sea necesario -->
            <div class="mt-5" v-if="isAlert">
                <div :class="alertClass">
                    <a href="#" class="close" @click="isAlert = !isAlert" aria-label="close">×</a>
                    <strong v-html="alertMessage"></strong>
                </div>
            </div>
            <div class="mt-5 mb-0">
                <h5>Create or Edit</h5>
                <br />
                <!-- Formulario para crear o editar una persona -->
                <form class="row" @submit.prevent="createOrUpdatePersona">
                    <div class="form-group p-1">
                        <input class="form-control" type="text" v-model="persona.nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group p-1">
                        <input type="text" class="form-control" v-model="persona.apellido" placeholder="Apellido">
                    </div>
                    <div class="form-group p-1">
                        <input type="text" class="form-control" v-model="persona.no_identificacion" placeholder="No. Identificación">
                    </div>
                    <div class="form-group p-1">
                        <input type="text" class="form-control" v-model="persona.direccion" placeholder="Dirección">
                    </div>
                    <div class="form-group p-1">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-info ml-1" @click="cancel">Cancelar</button>
                    </div>
                </form>
            </div>
            <!-- Tabla para mostrar la lista de personas -->
            <table class="mb-5 mt-5 table table-striped table-bordered mt-5">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>No. Identificación</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- La directiva "v-for" se utiliza para recorrer la lista de personas
                     y generar una fila de tabla por cada objeto. -->
                    <tr v-for="persona in personas">
                        <td>{{ persona.nombre }}</td>
                        <td>{{ persona.apellido }}</td>
                        <td>{{ persona.no_identificacion }}</td>
                        <td>{{ persona.direccion }}</td>
                        <td>
                            <button class="btn btn-primary" @click="editPersona(persona)">Editar</button>
                            <button class="btn btn-danger ml-1" @click="deletePersona(persona)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agregar la librería Vue, axios y el componente personas -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.47/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.3.3/dist/axios.min.js"></script>
    <script type="module" src="./componente/personas.js"></script>

</body>

</html>