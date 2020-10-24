var category = {
    add: function (check) {
        $.ajax({
            url: laroute.route('wiki.category.create.post'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                name_en : $('#name_en').val(),
                name_vi : $('#name_vi').val(),

            },
            success: function (res) {
                if (res.error == false) {
                    swal.fire(res.message, "", "success").then(function () {
                        if (check == 0){
                            window.location.href = laroute.route('wiki.category');
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    swal.fire(res.message, "", "error");
                }
            },
        });
    },

    edit: function () {
        $.ajax({
            url: laroute.route('wiki.category.edit.post'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                id : $('#id').val(),
                name_en : $('#name_en').val(),
                name_vi : $('#name_vi').val(),

            },
            success: function (res) {
                if (res.error == false) {
                    swal.fire(res.message, "", "success").then(function () {
                        window.location.href = laroute.route('wiki.category');
                    });
                } else {
                    swal.fire(res.message, "", "error");
                }
            },
        });
    },

    delete: function (id) {
        Swal.fire({
            title: xacnhanxoa,
            html: textCategory,
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel",
            confirmButtonText: xacnhan,
            cancelButtonText : huy ,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: laroute.route('wiki.category.delete.post'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        id : id,
                    },
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('wiki.category');
                            });
                        } else {
                            swal.fire(res.message, "", "error");
                        }
                    },
                });
            }
        })
    },
};

var knowledgebase = {
    add: function (check) {
        $.ajax({
            url: laroute.route('wiki.knowledge-base.create.post'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                name_en : $('#name_en').val(),
                name_vi : $('#name_vi').val(),
                description_en : $('#description_en').val(),
                description_vi : $('#description_vi').val(),
                category_id : $('#category_id').val(),

            },
            success: function (res) {
                if (res.error == false) {
                    swal.fire(res.message, "", "success").then(function () {
                        if (check == 0){
                            window.location.href = laroute.route('wiki.knowledge-base');
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    swal.fire(res.message, "", "error");
                }
            },
        });
    },

    edit: function () {
        $.ajax({
            url: laroute.route('wiki.knowledge-base.edit.post'),
            method: 'POST',
            dataType: 'JSON',
            data: {
                id : $('#id').val(),
                name_en : $('#name_en').val(),
                name_vi : $('#name_vi').val(),
                description_en : $('#description_en').val(),
                description_vi : $('#description_vi').val(),
                category_id : $('#category_id').val(),

            },
            success: function (res) {
                if (res.error == false) {
                    swal.fire(res.message, "", "success").then(function () {
                        window.location.href = laroute.route('wiki.knowledge-base');
                    });
                } else {
                    swal.fire(res.message, "", "error");
                }
            },
        });
    },

    delete: function (id) {
        Swal.fire({
            title: xacnhanxoabaiviet,
            html: textPost,
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonClass: "btn btn-sm btn-default btn-bold btn_yes",
            cancelButtonClass: "btn btn-sm btn-bold btn-brand btn_cancel",
            confirmButtonText: xacnhan,
            cancelButtonText : huy ,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: laroute.route('wiki.knowledge-base.delete.post'),
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        id : id
                    },
                    success: function (res) {
                        if (res.error == false) {
                            swal.fire(res.message, "", "success").then(function () {
                                window.location.href = laroute.route('wiki.knowledge-base');
                            });
                        } else {
                            swal.fire(res.message, "", "error");
                        }
                    },
                });
            }
        })
    },
};

$(document).ready(function () {
    // Summernote.init();

    $.uploadEn = function (file) {
        let out = new FormData();
        out.append('file', file, file.name);

        $.ajax({
            method: 'POST',
            url: laroute.route('wiki.upload.image'),
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function (img) {
                $("#description_en").summernote('insertImage', document.location.origin+'/uploads/image/'+img['file']);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };

    $.uploadVi = function (file) {
        let out = new FormData();
        out.append('file', file, file.name);

        $.ajax({
            method: 'POST',
            url: laroute.route('wiki.upload.image'),
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function (img) {
                $("#description_vi").summernote('insertImage', document.location.origin+'/uploads/image/'+img['file']);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };
})
