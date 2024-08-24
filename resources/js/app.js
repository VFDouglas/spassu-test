'use strict';

import './bootstrap';
import * as bootstrap from 'bootstrap';

/**
 * Headers automatically applied to all requests
 * @type {Headers}
 */
window.ajaxHeaders = new Headers({
    'Content-Type'    : 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN'    : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
});

window.atualizaTooltip = function() {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltip_trigger_element) {
        return new bootstrap.Tooltip(tooltip_trigger_element);
    });
};

window.FORMATA_VALOR = new Intl.NumberFormat('pt-BR', {
    style                : 'currency',
    currency             : 'BRL',
    minimumFractionDigits: 2,
});

document.addEventListener('click', function() {
    for (const item of document.querySelectorAll('.bs-tooltip-auto')) {
        item.remove();
    }
});
