//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Configurações do modelo
//-----------------------------------------------------------------------
const AuraApp = {
  //-------------------------------------------------------------------
  // Configurações do PWA
  PWA: {
    enable: true // Ativar ou desativar o PWA
  },
  //-------------------------------------------------------------------
  // Configurações do Dark Mode
  Dark_Mode: {
    default: false, // Define o modo escuro como principal
    local_mode: {
      // Ativa o modo escuro entre determinados horários do dia
      enable: false, // Ativar ou desativar o modo escuro local
      start_time: 20, // Início às 20:00
      end_time: 7 // Fim às 07:00
    },
    auto_detect: {
      // Detecte automaticamente as preferências do usuário e ative o modo escuro
      enable: false
    }
  },
  //-------------------------------------------------------------------
  // Configurações da direita para a esquerda (RTL)
  RTL: {
    enable: false // Ativar ou desativar o modo RTL
  },
  //-------------------------------------------------------------------
  // Animações
  Animation: {
    goBack: false // Ir para trás animação da página
  },
  //-------------------------------------------------------------------
  // Modo de teste
  Test: {
    enable: false, //Ativar ou desativar o modo de teste
    word: "mododetesteRHT", // A palavra que precisa ser digitada para ativar o modo de teste
    alert: true, // Ativar ou desativar o alerta quando o modo de teste é ativado
    alertMessage: "Modo de teste ativado. Olhe para o console do desenvolvedor!" // mensagem de alerta
  }
  //-------------------------------------------------------------------
};
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Elementos
//-----------------------------------------------------------------------
var pageBody = document.querySelector("body");
var appSidebar = document.getElementById("sidebarPanel");
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Trabalhadores de serviços
//-----------------------------------------------------------------------
if (AuraApp.PWA.enable) {
  if ("serviceWorker" in navigator) {
    // Registrar o primeiro service worker com um escopo específico
    navigator.serviceWorker
      .register("/service-worker.js") // Defina um escopo específico
      .then((reg) => console.log("Service worker 1 registrado com sucesso."))
      .catch((err) => console.log("Erro ao registrar o service worker 1", err));

    // Registrar o service worker para notificações do Firebase
    navigator.serviceWorker
      .register("firebase-messaging-sw.js") // Necessário no root para Firebase
      .then((reg) => console.log("Service worker 2 registrado com sucesso."))
      .catch((err) => console.log("Erro ao registrar o service worker 2", err));
  }
}
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Voltar Animação
function goBackAnimation() {
  pageBody.classList.add("animationGoBack");
  setTimeout(() => {
    window.history.go(-1);
  }, 300);
}
// Botão Voltar
var goBackButton = document.querySelectorAll(".goBack");
goBackButton.forEach(function (el) {
  el.addEventListener("click", function () {
    if (AuraApp.Animation.goBack) {
      goBackAnimation();
    } else {
      window.history.go(-1);
    }
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// RTL (da direita para a esquerda)
if (AuraApp.RTL.enable) {
  var pageHTML = document.querySelector("html");
  pageHTML.dir = "rtl";
  document.querySelector("body").classList.add("rtl-mode");
  if (appSidebar != null) {
    appSidebar.classList.remove("panelbox-left");
    appSidebar.classList.add("panelbox-right");
  }
  document
    .querySelectorAll(
      ".carousel-full, .carousel-single, .carousel-multiple, .carousel-small, .carousel-slider"
    )
    .forEach(function (el) {
      el.setAttribute("data-splide", '{"direction":"rtl"}');
    });
}
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Dica de ferramenta
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Correção para # href
//-----------------------------------------------------------------------
var aWithHref = document.querySelectorAll('a[href*="#"]');
aWithHref.forEach(function (el) {
  el.addEventListener("click", function (e) {
    e.preventDefault();
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Entrada
// Limpar entrada
var clearInput = document.querySelectorAll(".clear-input");
clearInput.forEach(function (el) {
  el.addEventListener("click", function () {
    var parent = this.parentElement;
    var input = parent.querySelector(".form-control");
    input.focus();
    input.value = "";
    parent.classList.remove("not-empty");
  });
});
// active
var formControl = document.querySelectorAll(".form-group .form-control");
formControl.forEach(function (el) {
  // active
  el.addEventListener("focus", () => {
    var parent = el.parentElement;
    parent.classList.add("active");
  });
  el.addEventListener("blur", () => {
    var parent = el.parentElement;
    parent.classList.remove("active");
  });
  // empty check
  el.addEventListener("keyup", log);
  function log(e) {
    var inputCheck = this.value.length;
    if (inputCheck > 0) {
      this.parentElement.classList.add("not-empty");
    } else {
      this.parentElement.classList.remove("not-empty");
    }
  }
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Searchbox Toggle
var searchboxToggle = document.querySelectorAll(".toggle-searchbox");
searchboxToggle.forEach(function (el) {
  el.addEventListener("click", function () {
    var search = document.getElementById("search");
    var a = search.classList.contains("show");
    if (a) {
      search.classList.remove("show");
    } else {
      search.classList.add("show");
      search.querySelector(".form-control").focus();
    }
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Carrossel
// Deslocar carrossel
document.addEventListener("DOMContentLoaded", function () {
  // Full Carousel
  document.querySelectorAll(".carousel-full").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 1,
      rewind: true,
      type: "loop",
      gap: 0,
      arrows: false,
      pagination: false
    }).mount()
  );

  // Single Carousel
  document.querySelectorAll(".carousel-single").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 3,
      rewind: true,
      type: "loop",
      gap: 16,
      padding: 16,
      arrows: false,
      pagination: false,
      breakpoints: {
        768: {
          perPage: 1
        },
        991: {
          perPage: 2
        }
      }
    }).mount()
  );

  // Multiple Carousel
  document.querySelectorAll(".carousel-multiple").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 4,
      rewind: true,
      type: "loop",
      gap: 16,
      padding: 16,
      arrows: false,
      pagination: false,
      breakpoints: {
        768: {
          perPage: 2
        },
        991: {
          perPage: 3
        }
      }
    }).mount()
  );

  // Small Carousel
  document.querySelectorAll(".carousel-small").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 9,
      rewind: false,
      type: "loop",
      gap: 16,
      padding: 16,
      arrows: false,
      pagination: false,
      breakpoints: {
        768: {
          perPage: 4
        },
        991: {
          perPage: 7
        }
      }
    }).mount()
  );

  // Slider Carousel
  document.querySelectorAll(".carousel-slider").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 1,
      rewind: false,
      type: "loop",
      gap: 16,
      padding: 16,
      arrows: false,
      pagination: true
    }).mount()
  );

  // Stories Carousel
  document.querySelectorAll(".story-block").forEach((carousel) =>
    new Splide(carousel, {
      perPage: 16,
      rewind: false,
      type: "slide",
      gap: 16,
      padding: 16,
      arrows: false,
      pagination: false,
      breakpoints: {
        500: {
          perPage: 4
        },
        768: {
          perPage: 7
        },
        1200: {
          perPage: 11
        }
      }
    }).mount()
  );
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Carregar entrada
var uploadComponent = document.querySelectorAll(".custom-file-upload");
uploadComponent.forEach(function (el) {
  var fileUploadParent = "#" + el.id;
  var fileInput = document.querySelector(
    fileUploadParent + ' input[type="file"]'
  );
  var fileLabel = document.querySelector(fileUploadParent + " label");
  var fileLabelText = document.querySelector(fileUploadParent + " label span");
  var filelabelDefault = fileLabelText.innerHTML;
  fileInput.addEventListener("change", function (event) {
    var name = this.value.split("\\").pop();
    tmppath = URL.createObjectURL(event.target.files[0]);
    if (name) {
      fileLabel.classList.add("file-uploaded");
      fileLabel.style.backgroundImage = "url(" + tmppath + ")";
      fileLabelText.innerHTML = name;
    } else {
      fileLabel.classList.remove("file-uploaded");
      fileLabelText.innerHTML = filelabelDefault;
    }
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Notificação
// dispara notificação
var notificationCloseButton = document.querySelectorAll(
  ".notification-box .close-button"
);
var notificationTaptoClose = document.querySelectorAll(
  ".tap-to-close .notification-dialog"
);
var notificationBox = document.querySelectorAll(".notification-box");

function closeNotificationBox() {
  notificationBox.forEach(function (el) {
    el.classList.remove("show");
  });
}
function notification(target, time) {
  var a = document.getElementById(target);
  closeNotificationBox();
  setTimeout(() => {
    a.classList.add("show");
  }, 250);
  if (time) {
    time = time + 250;
    setTimeout(() => {
      closeNotificationBox();
    }, time);
  }
}
// fechar notificação
notificationCloseButton.forEach(function (el) {
  el.addEventListener("click", function (e) {
    e.preventDefault();
    closeNotificationBox();
  });
});

// toque para fechar a notificação
notificationTaptoClose.forEach(function (el) {
  el.addEventListener("click", function (e) {
    closeNotificationBox();
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Brinde
// aciona o brinde
var toastCloseButton = document.querySelectorAll(".toast-box .close-button");
var toastTaptoClose = document.querySelectorAll(".toast-box.tap-to-close");
var toastBoxes = document.querySelectorAll(".toast-box");

function closeToastBox() {
  toastBoxes.forEach(function (el) {
    el.classList.remove("show");
  });
}
function toastbox(target, time) {
  var a = document.getElementById(target);
  closeToastBox();
  setTimeout(() => {
    a.classList.add("show");
  }, 100);
  if (time) {
    time = time + 100;
    setTimeout(() => {
      closeToastBox();
    }, time);
  }
}
// fechar brinde de botão
toastCloseButton.forEach(function (el) {
  el.addEventListener("click", function (e) {
    e.preventDefault();
    closeToastBox();
  });
});
// toque para fechar o brinde
toastTaptoClose.forEach(function (el) {
  el.addEventListener("click", function (e) {
    closeToastBox();
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Adicionar à página inicial
var osDetection = navigator.userAgent || navigator.vendor || window.opera;
var windowsPhoneDetection = /windows phone/i.test(osDetection);
var androidDetection = /android/i.test(osDetection);
var iosDetection = /iPad|iPhone|iPod/.test(osDetection) && !window.MSStream;

function iosAddtoHome() {
  var modal = new bootstrap.Modal(
    document.getElementById("ios-add-to-home-screen")
  );
  modal.toggle();
}
function androidAddtoHome() {
  var modal = new bootstrap.Modal(
    document.getElementById("android-add-to-home-screen")
  );
  modal.toggle();
}
function AddtoHome(time, once) {
  if (once) {
    var AddHomeStatus = localStorage.getItem("AuraAppAddtoHome");
    if (AddHomeStatus === "1" || AddHomeStatus === 1) {
      // already showed up
    } else {
      localStorage.setItem("AuraAppAddtoHome", 1);
      window.addEventListener("load", () => {
        if (navigator.standalone) {
          // if app installed ios home screen
        } else if (matchMedia("(display-mode: standalone)").matches) {
          // if app installed android home screen
        } else {
          // if app is not installed
          if (androidDetection) {
            setTimeout(() => {
              androidAddtoHome();
            }, time);
          }
          if (iosDetection) {
            setTimeout(() => {
              iosAddtoHome();
            }, time);
          }
        }
      });
    }
  } else {
    window.addEventListener("load", () => {
      if (navigator.standalone) {
        // aplicativo carregado para ios
      } else if (matchMedia("(display-mode: standalone)").matches) {
        // aplicativo carregado para android
      } else {
        // aplicativo não carregado
        if (androidDetection) {
          setTimeout(() => {
            androidAddtoHome();
          }, time);
        }
        if (iosDetection) {
          setTimeout(() => {
            iosAddtoHome();
          }, time);
        }
      }
    });
  }
}
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Dark Mode
var checkDarkModeStatus = localStorage.getItem("AuraAppDarkmode");
var switchDarkMode = document.querySelectorAll(".dark-mode-switch");
var pageBodyActive = pageBody.classList.contains("dark-mode");

// Verifique se habilitar como padrão
if (AuraApp.Dark_Mode.default) {
  pageBody.classList.add("dark-mode");
}

// Local Dark Mode
if (AuraApp.Dark_Mode.local_mode.enable) {
  var nightStart = AuraApp.Dark_Mode.local_mode.start_time;
  var nightEnd = AuraApp.Dark_Mode.local_mode.end_time;
  var currentDate = new Date();
  var currentHour = currentDate.getHours();
  if (currentHour >= nightStart || currentHour < nightEnd) {
    // It is night time
    pageBody.classList.add("dark-mode");
  }
}

// Detecção automática do Dark Mode
if (AuraApp.Dark_Mode.auto_detect.enable)
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    pageBody.classList.add("dark-mode");
  }

function switchDarkModeCheck(value) {
  switchDarkMode.forEach(function (el) {
    el.checked = value;
  });
}
// if dark mode on
if (
  checkDarkModeStatus === 1 ||
  checkDarkModeStatus === "1" ||
  pageBody.classList.contains("dark-mode")
) {
  switchDarkModeCheck(true);
  if (pageBodyActive) {
    // dark mode already activated
  } else {
    pageBody.classList.add("dark-mode");
  }
} else {
  switchDarkModeCheck(false);
}
switchDarkMode.forEach(function (el) {
  el.addEventListener("click", function () {
    var darkmodeCheck = localStorage.getItem("AuraAppDarkmode");
    var bodyCheck = pageBody.classList.contains("dark-mode");
    if (darkmodeCheck === 1 || darkmodeCheck === "1" || bodyCheck) {
      pageBody.classList.remove("dark-mode");
      localStorage.setItem("AuraAppDarkmode", "0");
      switchDarkModeCheck(false);
    } else {
      pageBody.classList.add("dark-mode");
      switchDarkModeCheck(true);
      localStorage.setItem("AuraAppDarkmode", "1");
    }
  });
});
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
// Modo de teste
function testMode() {
  var colorDanger = "color: #FF396F; font-weight:bold;";
  var colorSuccess = "color: #1DCC70; font-weight:bold;";

  console.clear();
  console.log(
    "%cADRIANO RIQUETTI",
    "font-size: 1.3em; font-weight: bold; color: #FFF; background-color: #6236FF; padding: 10px 120px; margin-bottom: 16px;"
  );
  console.log(
    "%c🚀 MODO DE TESTE ATIVADO ..!",
    "font-size: 1em; font-weight: bold; margin: 4px 0;"
  );

  function testModeMsg(value, msg) {
    if (value) {
      console.log(
        "%c|" + "%c " + msg + " : " + "%cEnabled",
        "color: #444; font-size :1.2em; font-weight: bold;",
        "color: inherit",
        colorSuccess
      );
    } else if (value == false) {
      console.log(
        "%c|" + "%c " + msg + " : " + "%cDisabled",
        "color: #444; font-size :1.2em; font-weight: bold;",
        "color: inherit",
        colorDanger
      );
    }
  }
  function testModeInfo(value, msg) {
    console.log(
      "%c|" + "%c " + msg + " : " + "%c" + value,
      "color: #444; font-size :1.2em; font-weight: bold;",
      "color: inherit",
      "color:#6236FF; font-weight: bold;"
    );
  }
  function testModeSubtitle(msg) {
    console.log(
      "%c # " + msg,
      "color: #FFF; background: #444; font-size: 1.2em; padding: 8px 16px; margin-top: 16px; border-radius: 12px 12px 0 0"
    );
  }

  testModeSubtitle("CONFIGURAÇÕES DE TEMA");
  testModeMsg(AuraApp.PWA.enable, "PWA");
  testModeMsg(
    AuraApp.Dark_Mode.default,
    "Defina o modo escuro como tema padrão"
  );
  testModeMsg(
    AuraApp.Dark_Mode.local_mode.enable,
    "Local dark mode (between " +
      AuraApp.Dark_Mode.local_mode.start_time +
      ":00 and " +
      AuraApp.Dark_Mode.local_mode.end_time +
      ":00)"
  );
  testModeMsg(AuraApp.Dark_Mode.auto_detect.enable, "Auto detect dark mode");
  testModeMsg(AuraApp.RTL.enable, "RTL");
  testModeMsg(AuraApp.Test.enable, "Test mode");
  testModeMsg(AuraApp.Test.alert, "Test mode alert");

  testModeSubtitle("PREVIEW INFOS");
  // Resolution
  testModeInfo(
    window.screen.availWidth + " x " + window.screen.availHeight,
    "Resolution"
  );
  // Device
  if (iosDetection) {
    testModeInfo("iOS", "Device");
  } else if (androidDetection) {
    testModeInfo("Android", "Device");
  } else if (windowsPhoneDetection) {
    testModeInfo("Windows Phone", "Device");
  } else {
    testModeInfo("Not a Mobile Device", "Device");
  }
  //Language
  testModeInfo(window.navigator.language, "Language");
  // Theme
  if (pageBody.classList.contains("dark-mode")) {
    testModeInfo("Dark Mode", "Current theme");
  } else {
    testModeInfo("Light Mode", "Current theme");
  }
  // Online Status
  if (window.navigator.onLine) {
    testModeInfo("Online", "Internet connection");
  } else {
    testModeInfo("Offline", "Internet connection");
  }

  testModeSubtitle("ANIMATIONS");
  testModeMsg(AuraApp.Animation.goBack, "Go Back");
}
function themeTesting() {
  var word = AuraApp.Test.word;
  var value = "";
  window.addEventListener("keypress", function (e) {
    value = value + String.fromCharCode(e.keyCode).toLowerCase();
    if (value.length > word.length) {
      value = value.slice(1);
    }
    if (value == word || value === word) {
      value = "";
      if (AuraApp.Test.alert) {
        var content = document.getElementById("appCapsule");
        content.appendChild(document.createElement("div")).className =
          "test-alert-wrapper";
        var alert =
          "<div id='alert-toast' class='toast-box toast-center tap-to-close'>" +
          "<div class='in'>" +
          "<div class='text'><h1 class='text-light mb-05'>🤖</h1><strong>" +
          AuraApp.Test.alertMessage +
          "</strong></div></div></div>";
        var wrapper = document.querySelector(".test-alert-wrapper");
        wrapper.innerHTML = alert;
        toastbox("alert-toast");
        setTimeout(() => {
          this.document.getElementById("alert-toast").classList.remove("show");
        }, 4000);
      }
      testMode();
    }
  });
}

if (AuraApp.Test.enable) {
  themeTesting();
}
//-----------------------------------------------------------------------

function statusError(statusMessage) {
  toastr.error(statusMessage, "Falha");
}
function statusInfo(statusMessage) {
  toastr.info(statusMessage, "Informação");
}
function statusToken(statusMessage) {
  toastr.error(statusMessage, "Token de Segurança");
}
function statusSucesso(statusMessage) {
  toastr.success(statusMessage, "Sucesso");
}
function statusAlert(statusMessage) {
  toastr.warning(statusMessage, "Atenção");
}
toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: true,
  progressBar: true,
  positionClass: "toast-top-right",
  preventDuplicates: true,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
  rtl: false,
  escapeHtml: true
};

function mascara(i) {
  var v = i.value;
  if (isNaN(v[v.length - 1])) {
    // impede entrar outro caractere que não seja número
    i.value = v.substring(0, v.length - 1);
    return;
  }
  i.setAttribute("maxlength", "14");
  if (v.length == 3 || v.length == 7) i.value += ".";
  if (v.length == 11) i.value += "-";
}

// Evento de sair
function Evento() {
  window.location.href = "logout";
}

function moeda(a, e, r, t) {
  let n = "",
    h = (j = 0),
    u = (tamanho2 = 0),
    l = (ajd2 = ""),
    o = window.Event ? t.which : t.keyCode;
  if (13 == o || 8 == o) return !0;
  if (((n = String.fromCharCode(o)), -1 == "0123456789".indexOf(n))) return !1;
  for (
    u = a.value.length, h = 0;
    h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r);
    h++
  );
  for (l = ""; h < u; h++)
    -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
  if (
    ((l += n),
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2)
  ) {
    for (ajd2 = "", j = 0, h = u - 3; h >= 0; h--)
      3 == j && ((ajd2 += e), (j = 0)), (ajd2 += l.charAt(h)), j++;
    for (a.value = "", tamanho2 = ajd2.length, h = tamanho2 - 1; h >= 0; h--)
      a.value += ajd2.charAt(h);
    a.value += r + l.substr(u - 2, u);
  }
  return !1;
}
