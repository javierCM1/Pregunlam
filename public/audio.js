document.addEventListener('DOMContentLoaded', function() {
    let audioPlayer = new Audio('/public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg');
    audioPlayer.loop = true;

    // Función para reproducir el audio
    function playAudio() {
        audioPlayer.play().catch(function(error) {
            console.log("Error al intentar reproducir el audio:", error);
        });
        setCookie('isPlaying', 'true', 7);
    }

    // Verificar si ya se está reproduciendo
    if (getCookie('isPlaying') !== 'true') {
        // Reproducir el audio al hacer clic en cualquier parte de la página
        document.body.addEventListener('click', function() {
            playAudio();
        }, { once: true }); // Eliminar el evento después de la primera interacción
    } else {
        // Si ya está en reproducción, simplemente reproducir
        audioPlayer.play().catch(function(error) {
            console.log("Error al intentar reproducir el audio:", error);
        });
    }
});
