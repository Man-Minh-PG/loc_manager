$(document).ready(function() {
    

    function updateDateTime(id, isParent){
        $.ajax({
            url: '_admin/loc/update/loc_datetime',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                isParent : isParent
            },
            success: function(response) {
                if (response.success) {
                    // Nếu thành công, hiển thị alert thành công
                    var alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('#alert-container').html(alertHtml);
                } else {
                    // Nếu thất bại, hiển thị alert lỗi
                    var alertHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('#alert-container').html(alertHtml);
                }
            },
            error: function(xhr, status, error) {
                // Nếu có lỗi trong việc gửi request (không liên quan đến logic của app)
                console.log('Error:', error);  // In ra thông báo lỗi chi tiết
                var alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Unexpected error occurred. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('#alert-container').html(alertHtml);
            }
        })
    }
});