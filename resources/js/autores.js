'use strict';

import * as bootstrap from 'bootstrap';

window.buscaAutores = function(autorId = '') {
    let options = {
        method : 'GET',
        headers: window.ajaxHeaders,
    };

    const params = new URLSearchParams({
        autorId: autorId,
    });

    fetch(`/api/autores?${params.toString()}`, options)
        .then(function(response) {
            if (!response.ok) {
                return false;
            }
            response.json().then(function(retorno) {
                document.getElementById('div_autores').innerHTML = '';
                if (retorno) {
                    if (retorno.length > 0) {
                        let html = '';
                        for (const item of retorno) {
                            html += `
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                                    <div class="card mb-1">
                                        <div class="card-header fw-bold text-primary-emphasis text-truncate py-3"
                                             data-bs-toggle="tooltip" title="${item.nome}" id="nome_${item.id}">
                                             <i class="fa-solid fa-inbox"></i>
                                            ${item.nome}
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger remove_autor text-decoration-none fw-medium"
                                            onclick="removeAutor(${item.id})" data-bs-toggle="tooltip"
                                            title="Excluir autor">
                                            <i class="fa-regular fa-trash-can" ></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary remove_autor text-decoration-none fw-medium"
                                            onclick="editaAutor(${item.id})" data-bs-toggle="tooltip"
                                            title="Editar autor">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </div>
                            `;
                        }
                        document.getElementById('div_autores').innerHTML = html;
                    } else {
                        document.getElementById('div_autores').innerHTML = `
                            <div class="col-12 text-center"><h5>Nenhum autor encontrado</h5></div>
                        `;
                    }
                } else {
                    alert('No autores found.');
                }
                window.atualizaTooltip();
            });
        });
};

buscaAutores();

window.removeAutor = function(id) {
    let options = {
        method : 'DELETE',
        headers: window.ajaxHeaders,
    };

    fetch(`./api/autores/${id}`, options).then(function(response) {
        if (!response.ok) {
            alert('Error retrieving data from the server');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.errors) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro')
                    .hide();
                buscaAutores();
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
            id  : idCadastro,
            nome: document.getElementById('nome_cadastro').value,
        }),
    };
    let url     = idCadastro ? `./api/autores/${idCadastro}` : './api/autores';

    fetch(url, options).then(function(response) {
        if (!response) {
            alert('Erro ao enviar requisição.');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.erro) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro').hide();
                buscaAutores();
            } else {
                alert(retorno.erro || 'Erro ao gravar autor.');
            }
        });
    });
});

window.editaAutor = function(idAutor) {
    document.getElementById('nome_cadastro').value = document
        .getElementById(`nome_${idAutor}`).innerText.trim();
    document.getElementById('id_cadastro').value   = idAutor;

    bootstrap.Modal.getOrCreateInstance('#modal_cadastro').show();
};
