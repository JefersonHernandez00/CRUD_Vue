// Importación y creación de la aplicación Vue
const { createApp } = Vue;

// Creación del objeto de datos
createApp({
  data() {
    return {
      // Array que almacena las personas recuperadas
      personas: [],
      // Objeto para almacenar los datos de la persona actualmente seleccionada
      persona: {
        nombre: '',
        apellido: '',
        no_identificacion: '',
        direccion: ''
      },
      // Bandera que indica si se debe mostrar o no una alerta
      isAlert: false,
      // Clase de Bootstrap para aplicar a la alerta
      alertClass: '',
      // Mensaje que se mostrará en la alerta
      alertMessage: ''
    }
  },
  methods: {
    // Método para obtener las personas desde el backend
    getPersonas() {
      axios.get('http://localhost/crud_vue/conexion/api.php?action=get_personas')
        .then(response => {
          this.personas = response.data;
          console.log(this.personas)
        })
        .catch(error => {
          console.error(error);
        });
    },
    // Método para crear o actualizar una persona
    createOrUpdatePersona() {
      // Verificación de que los campos obligatorios están completos
      if (!this.isComplete()) {
        this.alertMessage = '¡Requerido! Los campos no pueden estar vacíos'
        this.alertClass = 'alert alert-warning alert-dismissable'
        this.isAlert = true
        return
      }
      // Configuración de la alerta de éxito
      this.alertClass = 'alert alert-success alert-dismissable'
      if (!this.persona.id) {
        this.alertMessage = 'Datos creados con éxito'
      } else {
        this.alertMessage = 'Datos actualizados con éxito'
      }
      // Definición de la URL de acuerdo a si se está creando o actualizando una persona
      const url = this.persona.id ? 'http://localhost/crud_vue/conexion/api.php?action=update_persona' :
        'http://localhost/crud_vue/conexion/api.php?action=create_persona';
      // Envío de la solicitud al backend para guardar los datos
      axios.post(url, this.persona)
        .then(response => {
          // Mostrar la alerta de éxito y refrescar los datos
          this.isAlert = true
          this.getPersonas();
          this.cancel();
        })
        .catch(error => {
          console.error(error);
        });
    },
    // Método para editar una persona
    editPersona(persona) {
      // Crear una copia de la persona para no modificar la original
      this.persona = { ...persona };
    },
    // Método para eliminar una persona
    deletePersona(persona) {
      axios.post('http://localhost/crud_vue/conexion/api.php?action=delete_persona',
        { id: persona.id })
        .then(response => {
          // Mostrar la alerta de éxito y refrescar los datos
          this.alertClass = 'alert alert-danger alert-dismissable'
          this.alertMessage = 'Datos eliminados con éxito'
          this.isAlert = true
          this.getPersonas();
        })
        .catch(error => {
          console.error(error);
        });
    },
    // Método para cancelar la edición o creación de una persona
    cancel() {
      this.persona = {
        nombre: '',
        apellido: '',
        no_identificacion: '',
        direccion: ''
      };
    },
    // Método para verificar si los campos obligatorios están completos
    isComplete() {
      if (!this.persona.nombre || !this.persona.apellido || !this.persona.no_identificacion || !this.persona.direccion) {
        return false
      }
      return true
    }
  },
  // obtener datos de personas cuando se monta el componente Vue.
  mounted() {
    this.getPersonas();
  },
  //es una llamada a un método que se utiliza para montar la aplicación Vue 
}).mount("#app");