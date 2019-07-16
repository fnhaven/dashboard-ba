<div class="modal fade" id="modal-create-category" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">
                    Add new category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loader" style="display:none"></div>
                <div class="form-group form-create-category">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="name">
                    <div class="invalid-feedback" id="alert-name"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-submit"><i class="fas fa-plus" title="price"></i> Add</button>
            </div>
        </div>
    </div>
</div>


@section('js')
    @parent
    <script>
        require(['jquery', 'swal'], function( $ ) {
            let modal = $('#modal-create-category');
            let parent_id = '';
            let depth = '';
            let content = 'category'

            let showLoader = function() {
                modal.find('.modal-body').addClass('dimmer active');
                modal.find('.form-create-category').addClass('dimmer-content');
                modal.find('.btn-submit, .btn-update').addClass('disabled').attr('disabled');
                modal.find('.loader').show();
            };

            let hideLoader = function() {
                modal.find('.modal-body').removeClass('dimmer active');
                modal.find('.form-create-category').removeClass('dimmer-content');
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
                modal.find('.form-create-category :input:not(:button)').each(function(k, v){
                    $(this).removeClass('is-invalid');

                    if(v.type == 'text') v.value = '';
                    if(v.type == 'number') v.value = '0';
                });
            };

            let getFormData = function() {
                let data = {};

                modal.find('.form-create-category :input:not(:button)').each(function(k, v){
                    data[v.name] = v.value;
                });

                data['parent_id'] = parent_id;
                data['depth'] = depth;

                return data;
            };

            modal.on('show.bs.modal', function (e) {
                clearErrorMessages();
            });

            $(document).on('click', '[data-create="category"]', function(e){
                e.preventDefault();

                parent_id = '';
                depth = '';

                modal.find('#modal-title').text('Add new category');
            });

            $(document).on('click', '[data-create="subcategory"]', function(e){
                e.preventDefault();

                parent_id = $(this).data('parent-id');
                depth = $(this).data('depth');

                modal.find('#modal-title').text('Add new subcategory');
            });

            $(document).on('click', '[data-create="subcontent"]', function(e){
                e.preventDefault();

                parent_id = $(this).data('parent-id');
                depth = $(this).data('depth');

                modal.find('#modal-title').text('Add new content');
            });

            // Create
            $(document).on('click', '#modal-create-category .btn-submit:not(.disabled)', function(e){
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: '{{ url('api/category') }}',
                    data: getFormData(),
                    beforeSend: function(){
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
                        
                        parent_id = '';
                        depth = '';
                        content = 'category';

                        modal.hide();
                        swal("Hooray!", "Successfully to create new " + content + ".", "success")
                        .then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection