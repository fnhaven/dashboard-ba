<div class="modal fade" id="modal-edit-category" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">
                    Edit category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loader" style="display:none"></div>
                <div class="form-group form-edit-category">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="name">
                    <div class="invalid-feedback" id="alert-name"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-update">Update</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent
    <script>
        require(['jquery', 'swal'], function( $ ) {
            let modal = $('#modal-edit-category');
            let id = '';

            let showLoader = function() {
                modal.find('.modal-body').addClass('dimmer active');
                modal.find('.form-edit-category').addClass('dimmer-content');
                modal.find('.btn-submit, .btn-update').addClass('disabled').attr('disabled');
                modal.find('.loader').show();
            };

            let hideLoader = function() {
                modal.find('.modal-body').removeClass('dimmer active');
                modal.find('.form-edit-category').removeClass('dimmer-content');
                modal.find('.btn-submit, .btn-update').removeClass('disabled').removeAttr('disabled');
                modal.find('.loader').hide();
            };

            let showError = function(errors){
                let response = eval('(' + errors + ')');

                $.each(response.errors, function(key, val){
                    modal.find('[name="' + key + '"]').addClass("is-invalid");
                    modal.find('#alert-' + key).text(val[0]).show(300);
                });
            };

            let clearErrorMessages = function() {
                modal.find('.form-edit-category :input:not(:button)').each(function(k, v){
                    $(this).removeClass('is-invalid');

                    if(v.type == 'text') v.value = '';
                    if(v.type == 'number') v.value = '0';
                });
            };

            let getFormData = function() {
                let data = {};

                modal.find('.form-edit-category :input:not(:button)').each(function(k, v){
                    data[v.name] = v.value;
                });

                return data;
            };

            modal.on('show.bs.modal', function (e) {
                // clearErrorMessages();
            });

            $(document).on('click', '[data-update="category"]', function(e){
                e.preventDefault();

                id = $(this).data('id');

                modal.find('.form-edit-category :input[name=name]').val($(this).text());
                modal.find('#modal-title').text('Edit category');
            });

            $(document).on('click', '[data-update="subcategory"]', function(e){
                e.preventDefault();

                id = $(this).data('id');

                modal.find('.form-edit-category :input[name=name]').val($(this).find('span').text());
                modal.find('#modal-title').text('Edit subcategory');
            });

            $(document).on('click', '[data-update="subcontent"]', function(e){
                e.preventDefault();

                id = $(this).data('id');

                modal.find('.form-edit-category :input[name=name]').val($(this).find('small').text());
                modal.find('#modal-title').text('Edit content');
            });

            // update
            $(document).on('click', '#modal-edit-category .btn-update:not(.disabled)', function(e){
                e.preventDefault();

                $.ajax({
                    type: "PUT",
                    url: '{{ url('api/category') }}/' + id,
                    data: getFormData(),
                    beforeSend: function(){
                        clearErrorMessages();
                        showLoader()
                    },
                    error: function (data) {
                        hideLoader();

                        swal("Whoops!", data.responseJSON.message, "error").then(() => {
                            showError(data.responseText);
                        });
                    },
                    success: function () {
                        hideLoader();
                        
                        id = '';

                        modal.hide();
                        swal("Hooray!", "Successfully to create update this category.", "success")
                        .then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection