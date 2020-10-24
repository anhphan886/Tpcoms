var objDropzone = {
    init: function () {
        Dropzone.options.uploadFileTicket = {
            paramName: 'upload_file', // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            addRemoveLinks: true,
            dictRemoveFile: "Xóa file",
            dictDefaultMessage : "Kéo hoặc thả file vào đây để upload",
            dictCancelUpload : "Hủy tải lên",
            dictCancelUploadConfirmation : "Bạn có chắc chắn muốn hủy tải lên này?",
            dictMaxFilesExceeded : "Bạn không thể tải lên bất kỳ file nào nữa",
            dictFileTooBig : "Kích thước file quá lớn, tối đa là 1MB",
            dictInvalidFileType : "Bạn không thể tải lên các loại file này",
            acceptedFiles:'.doc,.docx,.xls,.xlsx,image/*,application/word',
            url: laroute.route('ticket.upload-img'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on('success', function (file, res) {
                    if (res.success) {
                        // $('#uploadFileTicket').after(`<input type="hidden" name="upload_file[]" value="${res.file.file_name}">`)
                        $('#uploadFileTicket .dz-preview').last().append(`<input type="hidden" name="upload_file[]" value="${res.file.file_name}">`)
                    }
                })
            }
        }
    }
}
