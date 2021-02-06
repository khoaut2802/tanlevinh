"use strict"

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#colorpicker").spectrum({
        color: "#f00"
    });

    $('.select2').select2({
        placeholder: "Chọn các thuộc tính",
        allowClear: true
    })

    $(".select2.attrs").each(function() {
        $(this).val($(this).attr('data-selected') != null ? JSON.parse($(this).attr('data-selected')) : [])
        $(this).trigger('change');
    })

    $('.select2-tags').select2({
        placeholder: "Chọn các thuộc tính",
        allowClear: true
    });    

    $('.select2-color').select2({
        placeholder: "Chọn các màu sắc",
        allowClear: true,
        templateSelection: function (data, container) {
            $(container).css("background-color", data.title);
            return data.text;
        },        
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
                        window.location.href = window.web_url + '/products/update/' + msg
                    }
                  })
            }
        });        
    })

    $('form#updateProductForm').on('submit', function(e) {
        e.preventDefault();
        var form = $('#updateProductForm')[0];
        var data = new FormData(form);

        $.ajax({
            url: window.web_url + '/products/update/' + window.slug,
            data: data,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(msg) {
                console.log(msg)
                swal({
                    title: "Congratulations!",
                    text: "Bạn đã cập nhật sản phẩm thành công.",
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

    $('.deleteModal').on('click', function() {
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "Bạn có chắc sẽ xóa sản phẩm này.",
            type: "error",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: `Xóa`
        }).then((result) => {
            if(result) {
                $.ajax({
                    url: window.web_url + '/products/' + id + '/delete',
                    data: {},
                    type: 'POST',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(msg) {
                        swal({
                            title: "Congratulations!",
                            text: "Bạn đã xóa sản phẩm thành công.",
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
            }
        })        
    }) 
});