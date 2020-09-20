require('./bootstrap');
require('admin-lte');
require('select2');
require('datatables.net');
require('datatables.net-bs4');



window.bsCustomFileInput = require('bs-custom-file-input');
window.bootbox           = require('bootbox');

$(document).ready(function () {
    $(document).on("click", ".delete-row-item", function (e) {
        e.preventDefault();
        const row     = $(e.currentTarget).data('row');
        const message = $(e.currentTarget).data('message');
        bootbox.confirm("Are you sure ?" + (message ? '<br>' + message : ''), function (result) {
            if (result) {
                document.getElementById('delete-row-item-form-' + row).submit();
            }
        });
    });

});
