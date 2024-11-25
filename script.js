// Função de adicionar curtida
function toggleLike(button) {
  const postContainer = button.closest(".post-container");
  const postId = postContainer.dataset.postId;

  const icon = button.querySelector("ion-icon");

  console.log("Post ID:", postId);

  fetch("functions/curtir.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      post_id: postId,
    }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro na requisição: " + response.status);
      }

      return response.json();
    })
    .then((data) => {
      console.log("Data recebida:", data);
      if (data.error) {
        alert(data.error);
        return;
      }

      const isLiked = icon.getAttribute("data-liked") === "true";

      icon.setAttribute("name", isLiked ? "heart-outline" : "heart");
      icon.setAttribute("data-liked", isLiked ? "false" : "true");

      const likeCountElement = postContainer.querySelector(".like-count");
      likeCountElement.textContent = data.curtidas + " Curtidas";
    })
    .catch((error) => {
      console.error("Erro na requisição:", error);
    });
}

// Função de logout
function Evento() {
  window.location.href = "logout";
}

function openSidebar() {
  document.querySelector(".sidebar-wrap").classList.add("active");
  document.getElementById("main-content").classList.add("blurred");
}

function closeSidebar() {
  document.querySelector(".sidebar-wrap").classList.remove("active");
  document.getElementById("main-content").classList.remove("blurred");
}

// Exemplo de ativação ao clicar no botão de abrir o menu
document.querySelector(".closemenu").addEventListener("click", closeSidebar);

// Função para selecionar pagina no menu
document.addEventListener("DOMContentLoaded", function () {
  const currentPage = window.location.pathname.split("/").pop();
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    link.classList.remove("active");
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
    }
  });
});

// Função para criar post
document.getElementById("createPostBtn").addEventListener("click", function () {

  Swal.fire({
    title: "Criar Post",
    html: `<form id="createPostForm" enctype="multipart/form-data">
                <div class="form-group" >
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="8"  required></textarea>
                </div>
                <div class="form-group">
                    <label for="image-upload" class="custom-file-upload">
                        <ion-icon name="image-outline" class="upload-icon"></ion-icon>
                        <img id="uploaded-image-preview" src="" alt="Preview" style="display: none;">
                    </label>
                    <input type="file" id="image-upload" name="image" accept="image/*" required>
                </div>

                <!-- Comunicados inseridos aqui, se necessário -->
                

                <button type="submit" class="submit-btn">Criar Post</button>
            </form>      
      `,
    showConfirmButton: false,
  });

  // Adicionar funcionalidade de preview de imagem
  document
    .getElementById("image-upload")
    .addEventListener("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const imagePreview = document.getElementById(
            "uploaded-image-preview"
          );
          imagePreview.src = e.target.result;
          imagePreview.style.display = "block";
          document.querySelector(".upload-icon").style.display = "none";
        };
        reader.readAsDataURL(file);
      }
    });

  document
    .getElementById("createPostForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      fetch("functions/create_post.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire("Sucesso!", data.message, "success").then(() => {
              location.reload();
            });
          } else {
            Swal.fire("Erro!", data.message, "error");
          }
        })
        .catch((error) => {
          console.error("Erro na requisição:", error);
          Swal.fire("Erro!", "Ocorreu um erro no envio do post.", "error");
        });
    });
});

