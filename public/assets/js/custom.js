"use strict"

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Chọn các thuộc tính",
        allowClear: true
    });

    $('.modal').on('click', function() {
        const target = $(this).attr('data-target');

        $(target).toggleClass('hidden');
    });

    $('.modal-close').on('click', function() {
        const target = $(this).attr('data-target');

        $(target).addClass('hidden');
    });

    $('form#addProductForm').on('submit', function(e) {
        e.preventDefault();
        var form = $('#addProductForm')[0];
        var data = new FormData(form);

        $.ajax({
            url: window.web_url + '/products/add',
            data: data,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(msg) {
                swal({
                    title: "Congratulations!",
                    text: "Bạn đã thêm sản phẩm thành công.",
                    type: "success",
                    timer: 3000,
                    showCancelButton: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showLoaderOnConfirm: true,
                    onClose() {
                        window.location.reload()
                    }
                  })
            }
        });        
    })
});