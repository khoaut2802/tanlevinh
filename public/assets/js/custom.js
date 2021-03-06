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
            success: function(result) {
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

    $('.changeOrderStauts').on('click', function() {
        var id = $(this).attr('data-id');
        var action = $(this).attr('data-action');
        var text;

        switch(action) {
            case 'completed':
                text = 'đã hoàn tất';
            break;
            case 'processing':
                text = 'đang xử lý';
            break;
            default:
                text = 'đã hủy bỏ';
        }

        swal({
            title: "Are you sure?",
            html: `Bạn có chắc sẽ chuyển trạng thái sản phẩm này sang <strong class="text-indigo-800">${text}</strong> không?.`,
            type: "info",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: `Xác nhận`,
            input: 'checkbox',
            inputPlaceholder: 'Gửi thư thông báo cho khách hàng.'
        }).then((result) => {
            console.log(result)
            var send_mail = 'no';

            if(result)
                send_mail = 'yes';

            if(result || result === 0) {
                $.ajax({
                    url: window.web_url + '/orders/update',
                    data: {id: id, action: action, send_mail: send_mail},
                    type: 'POST',
                    success: function(msg) {
                        swal({
                            title: "Congratulations!",
                            text: "Bạn đã cập nhật đơn hàng thành công.",
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

    $('#orderFilterLimit').on('change', function() {
        window.location.href = window.web_url + '/orders?per_page=' + $(this).val();
    })

    $('#orderFilterStatus').on('change', function() {
        window.location.href = window.web_url + '/orders?status=' + $(this).val();
    })
    $('#orderFilterMonth').on('change', function() {
        window.location.href = window.web_url + '/orders?month=' + $(this).val();
    })

    $('#productFilterLimit').on('change', function() {
        window.location.href = window.web_url + '/products?per_page=' + $(this).val();
    })

    $('#productFilterGroup').on('change', function() {
        window.location.href = window.web_url + '/products?group=' + $(this).val();
    })

    $('.editUser').on('click', function() {
        var id = $(this).attr('data-id');
        $('input[name="id"]').val(id);

        $.ajax({
            url: window.web_url + '/users/' + id + '/detail',
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                $('input[name="name"]').val(resp.name)
                $('input[name="email"]').val(resp.email)
                $('input[name="phone"]').val(resp.phone)
                $('input[name="address"]').val(resp.address)
                $('select[name="user_type"]').val(resp.user_type)

                if(resp.is_patron == 'yes')
                    $('input[name="patron"]').prop('checked', true)
                else
                    $('input[name="patron"]').prop('checked', false)

                $('#edit_user_modal').toggleClass('hidden');
            }
        });
    })

    $('#showCreateOrderModal').on('click', function() {
        $.ajax({
            url: window.web_url + '/orders/show-create-modal',
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                document.getElementById('order_modal').innerHTML = resp
            }
        });
    })

    $('.editOrder').on('click', function() {
        var code = $(this).attr('data-code');

        $.ajax({
            url: window.web_url + '/orders/' + code + '/show?action=edit',
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                document.getElementById('order_modal').innerHTML = resp
            }
        });
    })

    function parseOptions(arr) {
        var elem = ''
        arr.forEach(function(item, key) {
            elem += `<option value="${key}">${item.name}</option>`
        })

        return elem
    }

    function fetchProductAttr(id) {
        $.ajax({
            url: window.web_url + '/ajax/product/' + id,
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                document.getElementById('product_attrs_content').innerHTML = ''

                resp.forEach(function(item, key) {
                    document.getElementById('product_attrs_content').innerHTML += `<label class="block my-2">
                    <span class="text-gray-700">${item.name}:</span>
                    <select name="attr_${item.id}" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    ${parseOptions(item.options)}
                    </select>
                    </label>`
                })
            }
        });
    }


    $(document).on('change', 'select[name="product_group"]', function() {
        var id = $(this).val()

        $.ajax({
            url: window.web_url + '/ajax/groups/' + id,
            data: {},
            type: 'GET',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(resp) {
                document.getElementById('product_list').innerHTML = ''
                resp.forEach(function(item, key) {
                    if(key === 0)
                        fetchProductAttr(item.id)

                    document.getElementById('product_list').innerHTML += `<option value="${item.id}">${item.name}</option>`
                })
            }
        });
    })

    $(document).on('change', 'select[name="product"]', function() {
        var id = $(this).val()

        fetchProductAttr(id)
    })

    $(document).on('click', '.updateMachineModal', function() {
        var id = $(this).attr('data-code')
        $('input[name="id"]').val(id)
    })

    $(document).on('input', 'input[name="quantity"]', function() {
        calcPrintQty()
    })

    $(document).on('input', 'input[name="compensate"]', function() {
        calcPrintQty()
    })

    $(document).on('input', 'input[name="cut"]', function() {
        calcPrintQty()
    })

    function calcPrintQty() {
        var qty = $('input[name="quantity"]').val()
        var compensate = $('input[name="compensate"]').val()
        var cut = $('input[name="cut"]').val()
        var print_quantity = $('input[name="print_quantity"]')

        print_quantity.val(qty * cut - compensate)
    }

    $('#doublescroll').doubleScroll()
});
