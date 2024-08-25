'use strict';

import * as bootstrap from 'bootstrap';

window.Dropdown = bootstrap.Dropdown;

window.buscaLivros = function(livroId = '') {
    let options = {
        method : 'GET',
        headers: window.ajaxHeaders,
    };

    const params = new URLSearchParams({
        livroId: livroId,
    });

    fetch(`/api/livros?${params.toString()}`, options)
        .then(function(response) {
            if (!response.ok) {
                return false;
            }
            response.json().then(function(retorno) {
                document.getElementById('div_livros').innerHTML = '';
                if (retorno) {
                    if (retorno.length > 0) {
                        let html = '';
                        for (const item of retorno) {
                            html += `
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                                    <div class="card mb-1">
                                        <div class="card-header fw-bold text-primary-emphasis text-truncate"
                                             data-bs-toggle="tooltip" title="${item.titulo}" id="titulo_${item.id}">
                                            ${item.titulo}
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <i class="fa-regular fa-building" data-bs-toggle="tooltip"
                                                   title="Editora"></i>
                                                <span class="fw-medium" id="editora_${item.id}">${item.editora}</span>
                                            </div>
                                            <div class="text-info-emphasis">
                                                <i class="fa-regular fa-hashtag" data-bs-toggle="tooltip"
                                                   title="Edi&ccedil;&atilde;o"></i>
                                                <span class="fw-medium" id="edicao_${item.id}">${item.edicao}</span>
                                            </div>
                                            <div class="text-secondary">
                                                <i class="fa-regular fa-calendar-days" data-bs-toggle="tooltip"
                                                   title="Ano"></i>
                                                <span class="fw-medium" id="ano_${item.id}">${item.ano}</span>
                                            </div>
                                            <div>
                                                <input type="hidden" id="valor_${item.id}" value="${item.valor || '0'}">
                                                <input type="hidden" id="autor_${item.id}" value="${item.autor_id || ''}">
                                                <input type="hidden" id="assunto_${item.id}" value="${item.assunto_id || ''}">
                                                <span class="fw-medium text-success">
                                                    ${FORMATA_VALOR.format(item.valor || '0')}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger remove_livro text-decoration-none fw-medium"
                                            onclick="removeLivro(${item.id})" data-bs-toggle="tooltip"
                                            title="Excluir livro">
                                            <i class="fa-regular fa-trash-can" ></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary remove_livro text-decoration-none fw-medium"
                                            onclick="editaLivro(${item.id})" data-bs-toggle="tooltip"
                                            title="Editar livro">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </div>
                            `;
                        }
                        document.getElementById('div_livros').innerHTML = html;
                    } else {
                        document.getElementById('div_livros').innerHTML = `
                            <div class="col-12 text-center"><h5>Nenhum livro encontrado</h5></div>
                        `;
                    }
                } else {
                    alert('No livros found.');
                }
                window.atualizaTooltip();
            });
        });
};

buscaLivros();

window.removeLivro = function(id) {
    let options = {
        method : 'DELETE',
        headers: window.ajaxHeaders,
    };

    fetch(`./api/livros/${id}`, options).then(function(response) {
        if (!response.ok) {
            alert('Error retrieving data from the server');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.errors) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro')
                    .hide();
                buscaLivros();
            } else {
                alert(retorno.message || retorno.errors);
            }
        });
    });
};

document.getElementById('form_cadastro')?.addEventListener('submit', function(event) {
    event.preventDefault();
    let idCadastro = document.getElementById('id_cadastro').value;

    let options = {
        method : idCadastro ? 'PUT' : 'POST',
        headers: window.ajaxHeaders,
        body   : JSON.stringify({
            id        : idCadastro,
            titulo    : document.getElementById('titulo_cadastro').value,
            editora   : document.getElementById('editora_cadastro').value,
            edicao    : document.getElementById('edicao_cadastro').value,
            ano       : document.getElementById('ano_cadastro').value,
            valor     : document.getElementById('valor_cadastro').value,
            autor_id  : $('#autor_cadastro').val(),
            assunto_id: document.getElementById('assunto_cadastro').value,
        }),
    };
    let url     = idCadastro ? `./api/livros/${idCadastro}` : './api/livros';

    fetch(url, options).then(function(response) {
        if (!response) {
            alert('Erro ao enviar requisição.');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.erro) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro').hide();
                buscaLivros();
            } else {
                alert(retorno.erro || 'Erro ao gravar livro.');
            }
        });
    });
});

window.editaLivro = function(idLivro) {
    document.getElementById('titulo_cadastro').value  = document.getElementById(`titulo_${idLivro}`).innerText.trim();
    document.getElementById('editora_cadastro').value = document.getElementById(`editora_${idLivro}`).innerText.trim();
    document.getElementById('edicao_cadastro').value  = document.getElementById(`edicao_${idLivro}`).innerText.trim();
    document.getElementById('ano_cadastro').value     = document.getElementById(`ano_${idLivro}`).innerText.trim();
    document.getElementById('valor_cadastro').value   = document.getElementById(`valor_${idLivro}`).value;
    document.getElementById('assunto_cadastro').value = document.getElementById(`assunto_${idLivro}`).value || '';
    document.getElementById('id_cadastro').value      = idLivro;

    let opcoes = document.getElementById(`autor_${idLivro}`).value;
    for (let option of document.getElementById('autor_cadastro').options) {
        option.selected = !!opcoes.includes(+option.value);
    }
    $('.custom_select').selectpicker('destroy').selectpicker();

    bootstrap.Modal.getOrCreateInstance('#modal_cadastro').show();
};
$('.custom_select').selectpicker('destroy').selectpicker();
