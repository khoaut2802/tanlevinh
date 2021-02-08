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

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

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

        $('input[name="name"]').val('')
        $('textarea[name="description"]').val('')
        
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

    $('form#add_group_form').on('submit', function(e) {
        e.preventDefault();
        var form = $('#add_group_form')[0];
        var data = new FormData(form);

        $.ajax({
            url: window.web_url + '/groups/add',
            data: data,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(msg) {
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

    $('.groupEdit').on('click', function() {
        var id = $(this).attr('data-id');
        $('input[name="group_id"]').val(id);

        $.ajax({
            url: window.web_url + '/groups/' + id + '',
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                $('input[name="name"]').val(resp.name)
                $('textarea[name="description"]').val(resp.description)
                $('select[name="image_type"]').val(resp.image_type)
                $('#add_group_modal').toggleClass('hidden');
            }
        });            
    })     

    $('.groupDelete').on('click', function() {
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "Bạn có chắc sẽ xóa nhóm sản phẩm này. Việc xóa nhóm sản phẩm sẽ xóa toàn bộ sản phẩm!",
            type: "error",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: `Xóa`
        }).then((result) => {
            if(result) {
                $.ajax({
                    url: window.web_url + '/groups/' + id + '/delete',
                    data: {},
                    type: 'POST',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(msg) {
                        swal({
                            title: "Congratulations!",
                            text: "Bạn đã xóa nhóm sản phẩm thành công.",
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

    $('form#addBannerForm').on('submit', function(e) {
        e.preventDefault();
        var form = $('#addBannerForm')[0];
        var data = new FormData(form);

        $.ajax({
            url: window.web_url + '/banners/add/',
            data: data,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(result, textStatus, xhr) {
                swal({
                    title: "Congratulations!",
                    text: result,
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
            },
            complete: function(xhr, textStatus) {
                if(xhr.status != 200) {
                    console.log(xhr)
                    swal({
                        title: "Đã xảy ra lỗi!",
                        text: xhr.responseJSON,
                        type: "error",
                        timer: 3000,
                        showCancelButton: false,
                        showCloseButton: false,
                        showConfirmButton: false,
                        showLoaderOnConfirm: true
                    })                    
                }
            } 
        });        
    })
});