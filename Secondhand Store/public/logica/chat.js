    let typingTimer;

    const messageInput = document.getElementById('mensaje');
    const formEnviarMensaje = document.getElementById('formEnviarMensaje');

    function enviarFormulario() {
        formEnviarMensaje.submit();
    }

    function activarTemporizador() {
        typingTimer = setInterval(enviarFormulario, 4000); // Envía el formulario cada 5 segundos
    }

    function desactivarTemporizador() {
        clearInterval(typingTimer); // Pausa el temporizador
    }

    // Evento cuando el input obtiene el foco
    messageInput.addEventListener('focus', function () {
        desactivarTemporizador();
    });

    // Evento cuando el input pierde el foco
    messageInput.addEventListener('blur', function () {
        activarTemporizador();
    });

    // Configura el temporizador inicialmente
    activarTemporizador();

    document.getElementById('cajaMensajes').scrollTo(0,document.body.scrollHeight);