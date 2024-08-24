'use strict';

import * as bootstrap from 'bootstrap';

window.buscaAssuntos = function(assuntoId = '') {
    let options = {
        method : 'GET',
        headers: window.ajaxHeaders,
    };

    const params = new URLSearchParams({
        assuntoId: assuntoId,
    });

    fetch(`/api/assuntos?${params.toString()}`, options)
        .then(function(response) {
            if (!response.ok) {
                return false;
            }
            response.json().then(function(retorno) {
                document.getElementById('div_assuntos').innerHTML = '';
                if (retorno) {
                    if (retorno.length > 0) {
                        let html = '';
                        for (const item of retorno) {
                            html += `
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                                    <div class="card mb-1">
                                        <div class="card-header fw-bold text-primary-emphasis text-truncate py-3"
                                             data-bs-toggle="tooltip" title="${item.descricao}" id="descricao_${item.id}">
                                             <i class="fa-solid fa-inbox"></i>
                                            ${item.descricao}
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger remove_assunto text-decoration-none fw-medium"
                                            onclick="removeAssunto(${item.id})" data-bs-toggle="tooltip"
                                            title="Excluir assunto">
                                            <i class="fa-regular fa-trash-can" ></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary remove_assunto text-decoration-none fw-medium"
                                            onclick="editaAssunto(${item.id})" data-bs-toggle="tooltip"
                                            title="Editar assunto">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </div>
                            `;
                        }
                        document.getElementById('div_assuntos').innerHTML = html;
                    } else {
                        document.getElementById('div_assuntos').innerHTML = `
                            <div class="col-12 text-center"><h5>Nenhum assunto encontrado</h5></div>
                        `;
                    }
                } else {
                    alert('No assuntos found.');
                }
                window.atualizaTooltip();
            });
        });
};

buscaAssuntos();

window.removeAssunto = function(id) {
    let options = {
        method : 'DELETE',
        headers: window.ajaxHeaders,
    };

    fetch(`./api/assuntos/${id}`, options).then(function(response) {
        if (!response.ok) {
            alert('Error retrieving data from the server');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.errors) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro')
                    .hide();
                buscaAssuntos();
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
            id       : idCadastro,
            descricao: document.getElementById('descricao_cadastro').value,
        }),
    };
    let url     = idCadastro ? `./api/assuntos/${idCadastro}` : './api/assuntos';

    fetch(url, options).then(function(response) {
        if (!response) {
            alert('Erro ao enviar requisição.');
            return false;
        }
        response.json().then(function(retorno) {
            if (!retorno.erro) {
                bootstrap.Modal.getOrCreateInstance('#modal_cadastro').hide();
                buscaAssuntos();
            } else {
                alert(retorno.erro || 'Erro ao gravar assunto.');
            }
        });
    });
});

window.editaAssunto = function(idAssunto) {
    document.getElementById('descricao_cadastro').value = document
        .getElementById(`descricao_${idAssunto}`).innerText.trim();
    document.getElementById('id_cadastro').value        = idAssunto;

    bootstrap.Modal.getOrCreateInstance('#modal_cadastro').show();
};
