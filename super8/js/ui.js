
(function () {
	"use strict";

	function exibirAlerta(mensagem) {
		if (mensagem) {
			window.alert(mensagem);
		}
	}

	function confirmarAcao(mensagem) {
		return window.confirm(mensagem || "Tem certeza?");
	}

	function imprimirPagina() {
		window.print();
	}

	function ativarConfirmacaoReiniciar(seletor) {
		var links = document.querySelectorAll(seletor || "[data-confirmar-reinicio]");

		links.forEach(function (link) {
			link.addEventListener("click", function (evento) {
				var mensagem = link.getAttribute("data-mensagem-confirmacao") || "Tem certeza que deseja reiniciar o torneio?";

				if (!confirmarAcao(mensagem)) {
					evento.preventDefault();
				}
			});
		});
	}

	function ativarBotaoImpressao(seletor) {
		var botoes = document.querySelectorAll(seletor || "[data-imprimir-pagina]");

		botoes.forEach(function (botao) {
			botao.addEventListener("click", function () {
				imprimirPagina();
			});
		});
	}

	function ativarFeedbackFormulario(seletor) {
		var formularios = document.querySelectorAll(seletor || "form");

		formularios.forEach(function (formulario) {
			formulario.addEventListener("submit", function () {
				var botao = formulario.querySelector('button[type="submit"], input[type="submit"]');

				if (!botao) {
					return;
				}

				if (!botao.dataset.textoOriginal) {
					botao.dataset.textoOriginal = botao.tagName === "BUTTON" ? botao.textContent : botao.value;
				}

				if (botao.tagName === "BUTTON") {
					botao.textContent = "Enviando...";
				} else {
					botao.value = "Enviando...";
				}

				botao.disabled = true;
			});
		});
	}

	async function enviarFormularioAssincrono(formulario) {
		return fetch(formulario.action, {
			method: (formulario.method || "POST").toUpperCase(),
			body: new FormData(formulario)
		});
	}

	window.Super8UI = {
		exibirAlerta: exibirAlerta,
		confirmarAcao: confirmarAcao,
		imprimirPagina: imprimirPagina,
		ativarConfirmacaoReiniciar: ativarConfirmacaoReiniciar,
		ativarBotaoImpressao: ativarBotaoImpressao,
		ativarFeedbackFormulario: ativarFeedbackFormulario,
		enviarFormularioAssincrono: enviarFormularioAssincrono
	};

	document.addEventListener("DOMContentLoaded", function () {
		ativarConfirmacaoReiniciar();
		ativarBotaoImpressao();
		ativarFeedbackFormulario();
	});
})();
