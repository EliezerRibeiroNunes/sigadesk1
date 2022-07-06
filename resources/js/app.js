import './bootstrap';
import $ from "jquery";
import Swal from 'sweetalert2';


$(function () {
    $('form[role="ajax"]').on('submit', function () {
        var route = $(this).attr('action');

        $.post(route, $(this).serialize(), function (data) {
            globalActionReturnAjax(data)
        });

        return false;
    });


    $('.btn-remove[role="ajax"]').on('click', function () {
        var route = $(this).attr('route');
        var requests = {
            _method: "DELETE",
            _token: $(this).attr('csrf')
        };

        $.post(route, requests, function (data) {
            globalActionReturnAjax(data)
        });
    });

    $('.btn-edit-category').on('click', function (){
        var elementProp = $(this).closest('ol'),
            name = elementProp.attr('data-name'),
            routeEdit = elementProp.attr('data-route-edit'),
            routeDestroy = elementProp.attr('data-route-destroy'),
            modalId = 'modaledit',
            elementModal = $(`#${modalId}`),
            instanceModal = new bootstrap.Modal(document.getElementById(modalId), {});

        elementModal.find('form').attr('action', routeEdit);
        elementModal.find('input[name="name"]').val(name);
        elementModal.find('.btn-remove').attr('route', routeDestroy);

        instanceModal.show();
    });
});

function globalActionReturnAjax(data) {
    if (!data.status) {

        Swal.fire(
            'Ops',
            data.errors[0],
            'warning'
        );
    } else {
        Swal.fire('Concluído!', data.message, 'success')
            .then(() => {
                window.location.href = data.redirect;
            });
    }
}
