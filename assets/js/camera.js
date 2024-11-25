let currentCamera = "environment"; // 'user' para câmera frontal, 'environment' para câmera traseira
let videoStream = null; // Variável para armazenar o stream de vídeo atual

async function toggleCamera() {
  try {
    const video = document.getElementById("video");

    // Verifica se o vídeo está sendo reproduzido
    if (videoStream && !video.paused) {
      video.pause();
      videoStream.getTracks().forEach((track) => track.stop());
    }

       currentCamera = (currentCamera === 'user') ? 'environment' : 'user';

    // Obtém o novo stream da câmera selecionada
    const constraints = {
      video: {
        facingMode: { exact: currentCamera }
      }
    };

    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    video.srcObject = stream;
    videoStream = stream; // Armazena o stream atual
    video.play();
  } catch (error) {
    console.error("Erro ao alternar câmera:", error);
  }
}

// Alterna entre 'user' (frontal) e 'environment' (traseira)
function toggleCameraFacingMode() {
  currentCamera = currentCamera === "user" ? "environment" : "user";
  toggleCamera(); // Chama a função para atualizar a câmera com o modo selecionado
}

// Quando a página carregar, começa com a câmera traseira
window.onload = function () {
  toggleCamera();
};

// Capturar imagem quando o botão for clicado
const captureButton = document.getElementById("capture-button");
captureButton.addEventListener("click", function () {
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");
  const video = document.getElementById("video");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Converta a imagem do canvas em base64
  const imageData = canvas.toDataURL("image/png");

  // Envia a imagem para o servidor PHP (substitua pela sua lógica de envio)
  enviarImagem(imageData);
});

function capturarEEnviar(id, etiqueta) {
  const overlay = document.getElementById("overlay");
  overlay.style.display = "flex"; // Mostra o overlay de espera

  const video = document.getElementById("video");
  const canvas = document.createElement("canvas");
  const context = canvas.getContext("2d");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Converta a imagem do canvas em base64
  const imageData = canvas.toDataURL("image/jpeg");

  // Gere um número aleatório entre 1000 e 9999
  const numeroAleatorio = Math.floor(Math.random() * 9000) + 1000;

  // Gere o nome do arquivo temporário com data atual e número aleatório
  const currentDate = new Date();
  const formattedDate = currentDate
    .toISOString()
    .slice(0, 10)
    .replace(/-/g, ""); // Formato YYYYMMDD
  const formattedTime = currentDate
    .toISOString()
    .slice(11, 16)
    .replace(":", ""); // Formato HHMM (sem dois pontos)
  const nomeArquivo = `temp${numeroAleatorio}-${formattedDate}-${formattedTime}.jpeg`;

  // Envia a imagem para o servidor
  enviarImagem(imageData, nomeArquivo, id, etiqueta);
}

function enviarImagem(imageData, nomeArquivo, id, etiqueta) {
  const xhr = new XMLHttpRequest();
  const params = `imagem=${encodeURIComponent(
    imageData
  )}&etiqueta=${etiqueta}&nomeArquivo=${encodeURIComponent(nomeArquivo)}`;
  xhr.open("POST", "salvar_imagem.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const urlImagem = `documents/${nomeArquivo}`;
      window.location.href = `app-confirmar?id=${id}&etiqueta=${etiqueta}&url=${encodeURIComponent(
        urlImagem
      )}`;
    }
  };
  xhr.send(params);
}

function capturarEEnviar2(id) {
  const overlay = document.getElementById("overlay");
  overlay.style.display = "flex"; // Mostra o overlay de espera

  const video = document.getElementById("video");
  const canvas = document.createElement("canvas");
  const context = canvas.getContext("2d");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Converta a imagem do canvas em base64
  const imageData = canvas.toDataURL("image/jpeg");

  // Envia a imagem para o servidor
  enviarImagem2(imageData, id);
}

function enviarImagem2(imageData, id) {
  const xhr = new XMLHttpRequest();
  const params = `imagem=${encodeURIComponent(imageData)}&id=${encodeURIComponent(id)}`;
  xhr.open("POST", "functions/InserirTicket.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.status === 'success') {
          // Sucesso, redirecionar ou mostrar mensagem de sucesso
          window.location.href = `app-abastecimento?sucesso=${encodeURIComponent(response.message)}`;
        } else {
           window.location.href = `app-ticket?error=${encodeURIComponent(response.message)}&id=${encodeURIComponent(id)}`;
        }
      } else {
        window.location.href = `app-ticket?error=${encodeURIComponent(xhr.statusText)}&id=${encodeURIComponent(id)}`;
      }
    }
  };
  xhr.send(params);
}

function capturarEEnviar3(id) {
  const overlay = document.getElementById("overlay");
  overlay.style.display = "flex"; // Mostra o overlay de espera

  const video = document.getElementById("video");
  const canvas = document.createElement("canvas");
  const context = canvas.getContext("2d");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Converta a imagem do canvas em base64
  const imageData = canvas.toDataURL("image/jpeg");

  // Envia a imagem para o servidor
  enviarImagem3(imageData, id);
}

function enviarImagem3(imageData, id) {
  const xhr = new XMLHttpRequest();
  const params = `imagem=${encodeURIComponent(imageData)}&id=${encodeURIComponent(id)}`;
  xhr.open("POST", "functions/inserirFoto.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.status === 'success') {
          // Sucesso, redirecionar ou mostrar mensagem de sucesso
          window.location.href = `app-home?sucesso=${encodeURIComponent(response.message)}`;
        } else {
           window.location.href = `app-parada?error=${encodeURIComponent(response.message)}&id=${encodeURIComponent(id)}`;
        }
      } else {
        window.location.href = `app-parada?error=${encodeURIComponent(xhr.statusText)}&id=${encodeURIComponent(id)}`;
      }
    }
  };
  xhr.send(params);
}