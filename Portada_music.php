<?php
// Verificar si se ha pasado el nombre de la canción y la URL de la carátula por la URL
if (isset($_GET['song_name'])&&isset($_GET['song_artist'])) {
    $songName = htmlspecialchars($_GET['song_name']);
    $song_artist = htmlspecialchars($_GET['song_artist']);
    $songPath = 'Music_temp/' . $songName . '.mp3'; // Ruta a la canción
    $imagePath = 'Music_temp/' . $songName . 'Image.jpg'; // Ruta de la imagen
} else {
    // Si no se ha pasado la información necesaria, redirigir a la página principal
    header("Location: Prueba.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación de Canción - Tipo Spotify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            overflow: hidden; /* Evitar scroll */
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?php echo $imagePath; ?>');
            background-size: cover; /* Cubrir toda la pantalla */
            background-position: center; /* Centrar la imagen */
            z-index: 0; /* Colocar detrás del contenido */
        }

        .song-container {
            position: relative; /* Para mantener la posición relativa respecto a la imagen de fondo */
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(30, 30, 30, 0.8); /* Fondo semi-transparente */
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1; /* Colocar encima de la imagen de fondo */
            margin: auto; /* Centrar el contenedor */
            margin-top: 50px; /* Espacio desde la parte superior */
        }

        .album-cover img {
            width: 300px;
            height: 300px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .song-info {
            text-align: center;
            margin-bottom: 20px;
            color: white; /* Color del texto */
        }

        .controls-container {
            width: 100%;
            background-color: #282828;
            position: fixed;
            bottom: 0;
            left: 0;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1; /* Colocar encima de la imagen de fondo */
        }

        .controls {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .play-pause-btn {
            width: 50px;
            height: 50px;
            background-color: #1DB954;
            border: none;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
        }

        .progress-bar-container {
            flex-grow: 1;
            margin: 0 20px;
        }

        .progress-bar {
            width: 100%;
            height: 5px;
            background-color: #404040;
            position: relative;
            cursor: pointer;
        }

        .progress {
            height: 100%;
            background-color: #1DB954;
            width: 0;
        }

        .time {
            font-size: 12px;
            color: #b3b3b3;
        }

        .volume-container {
            display: flex;
            align-items: center;
        }

        .volume-slider {
            width: 100px;
            margin-left: 10px;
        }

        .control-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .control-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 20px;
        }

        .control-btn:hover {
            color: #1DB954;
        }

        .active-repeat {
            color: #1DB954; /* Color cuando está activo */
        }
        /* Estilos para la ventana modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 2; /* Encima de todo */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 24px;
            color: #333;
        }

    </style>
</head>
<body>

<div class="background-image"></div> <!-- Imagen de fondo -->

<div class="song-container">
    <!-- Carátula del álbum -->
    <div class="album-cover">
        <img src="<?php echo $imagePath; ?>" alt="music-image" />
    </div>

    <!-- Información de la canción -->
    <div class="song-info">
        <h2><?php echo $songName; ?></h2>
        <p> Artista: <?php echo $song_artist; ?></p>
    </div>
</div>
<!-- Ventana modal para crear playlist -->
<div id="playlistModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Crear nueva playlist</h2>
        <form id="playlistForm">
            <label for="playlistName">Nombre de la Playlist:</label>
            <input type="text" id="playlistName" name="playlistName" required>
            <button type="submit" id="createPlaylistBtn">Crear</button>
        </form>
    </div>
</div>


<!-- Controles de reproducción en la parte inferior -->
<div class="controls-container">
    <div class="controls">
        <button class="control-btn" id="prevBtn">⏮</button>
        <button class="play-pause-btn" id="playPauseBtn">&#9654;</button>
        <button class="control-btn" id="nextBtn">⏭</button>
        <button class="control-btn" id="repeatBtn">🔁</button>
        <div class="progress-bar-container">
            <div class="progress-bar" id="progressBar">
                <div class="progress" id="progress"></div>
            </div>
        </div>
        <span class="time" id="currentTime">0:00</span> &nbsp; / &nbsp;
        <span class="time" id="duration">0:00</span>
        <div class="control-buttons">
            <button class="control-btn" id="favBtn">❤️</button>
            <button class="control-btn" id="playlistBtn">➕</button>
            <div class="volume-container">
                <button class="control-btn" id="muteBtn">🔊</button>
                <input type="range" id="volumeSlider" class="volume-slider" min="0" max="1" step="0.01" value="1">
            </div>
        </div>
    </div>
</div>

<!-- Elemento de audio oculto -->
<audio id="audioPlayer">
    <source src="<?php echo $songPath; ?>" type="audio/mpeg">
    Tu navegador no soporta el elemento de audio.
</audio>

<script>
    const audioPlayer = document.getElementById('audioPlayer');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const progressBar = document.getElementById('progressBar');
    const progress = document.getElementById('progress');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');
    const volumeSlider = document.getElementById('volumeSlider');
    const muteBtn = document.getElementById('muteBtn');
    const repeatBtn = document.getElementById('repeatBtn');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    let isMuted = false;
    let isRepeating = false;

    // Cambiar el ícono del botón Play/Pause y controlar la reproducción
    playPauseBtn.addEventListener('click', () => {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playPauseBtn.innerHTML = '⏸'; // Icono de pausa
        } else {
            audioPlayer.pause();
            playPauseBtn.innerHTML = '▶'; // Icono de play
        }
    });

    // Actualizar barra de progreso y tiempo
    audioPlayer.addEventListener('timeupdate', () => {
        const { currentTime, duration } = audioPlayer;
        const progressPercent = (currentTime / duration) * 100;
        progress.style.width = `${progressPercent}%`;

        currentTimeEl.textContent = formatTime(currentTime);
        durationEl.textContent = formatTime(duration);
    });

    // Controlar la barra de progreso manualmente
    progressBar.addEventListener('click', (e) => {
        const width = progressBar.clientWidth;
        const clickX = e.offsetX;
        const duration = audioPlayer.duration;

        audioPlayer.currentTime = (clickX / width) * duration;
    });

    // Controlar el volumen
    volumeSlider.addEventListener('input', () => {
        audioPlayer.volume = volumeSlider.value;
    });

    // Controlar silencio
    muteBtn.addEventListener('click', () => {
        if (isMuted) {
            audioPlayer.muted = false;
            muteBtn.textContent = '🔊'; // Volumen activo
        } else {
            audioPlayer.muted = true;
            muteBtn.textContent = '🔇'; // Silencio activado
        }
        isMuted = !isMuted;
    });

    // Repetir canción
    repeatBtn.addEventListener('click', () => {
        if (isRepeating) {
            repeatBtn.textContent = '🔁'; // Ícono para repetir
        } else {
            repeatBtn.textContent = '🔂'; // Ícono para no repetir
        }
        isRepeating = !isRepeating;
        audioPlayer.loop = isRepeating;

        // Cambia el color cuando se activa
        repeatBtn.classList.toggle('active-repeat', isRepeating);
    });

    // Acción para siguiente canción
    nextBtn.addEventListener('click', () => {
        alert('Siguiente canción (Funcionalidad a implementar)');
    });

    // Acción para canción anterior
    prevBtn.addEventListener('click', () => {
        alert('Canción anterior (Funcionalidad a implementar)');
    });

    // Formatear el tiempo en minutos y segundos
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs < 10 ? '0' + secs : secs}`;
    }

    // Acción al presionar favoritos
    document.getElementById('favBtn').addEventListener('click', () => {
        alert('Añadido a favoritos');
    });
    
    // Obtener elementos
const playlistBtn = document.getElementById('playlistBtn');
const playlistModal = document.getElementById('playlistModal');
const closeBtn = document.querySelector('.close-btn');
const playlistForm = document.getElementById('playlistForm');

// Mostrar el modal al hacer clic en el botón de añadir playlist
playlistBtn.addEventListener('click', () => {
    playlistModal.style.display = 'flex'; // Mostrar el modal
});

// Ocultar el modal al hacer clic en el botón de cerrar
closeBtn.addEventListener('click', () => {
    playlistModal.style.display = 'none'; // Ocultar el modal
});

// Ocultar el modal al hacer clic fuera del contenido del modal
window.addEventListener('click', (event) => {
    if (event.target === playlistModal) {
        playlistModal.style.display = 'none'; // Ocultar el modal
    }
});

// Manejar la creación de la playlist
playlistForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const playlistName = document.getElementById('playlistName').value;

    if (playlistName) {
        alert(`Playlist "${playlistName}" creada con éxito!`);
        playlistModal.style.display = 'none'; // Ocultar el modal
    }
});

        
    
</script>

</body>
</html>
