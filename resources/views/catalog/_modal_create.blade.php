<div class="modal fade" id="modal-create-product" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">
                    Add new Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loader" style="display:none"></div>
                <form class="form-group form-create-product">
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="DigiToys, etc...">
                        <div class="invalid-feedback" id="alert-name"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-control custom-select" name="category">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="alert-category"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <input type="text" class="form-control" id="input-tags" name="tags" value="" placeholder="instahit, instagoods" tabindex="-1" style="display: none;">
                        <div class="invalid-feedback" id="alert-tags"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea type="text" name="description" class="form-control" rows="5"></textarea>
                        <div class="invalid-feedback" id="alert-description"></div>
                    </div>

                    <div class="form-group">
                        <div class="form-label">Image</div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" accept="image/*">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="invalid-feedback" id="alert-image"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Price [IDR]</label>
                        <input type="number" name="price" class="form-control" value="1000">
                        <div class="invalid-feedback" id="alert-price"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="0">
                        <div class="invalid-feedback" id="alert-stock"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control" value="0">
                        <div class="invalid-feedback" id="alert-discount"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Discout type</label>
                        <select class="form-control custom-select" name="discount-type">
                          <option value="percentage" selected>Percentage</option>
                          <option value="value">Value</option>
                        </select>
                        <div class="invalid-feedback" id="alert-discount-type"></div>
                    </div>
                </form>
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
        require(['jquery', 'swal', 'selectize'], function( $ ) {
            let modal = $('#modal-create-product');
            let form = modal.find('.form-create-product');

            let showLoader = function() {
                modal.find('.modal-body').addClass('dimmer active');
                form.addClass('dimmer-content');
                modal.find('.btn-submit, .btn-update').addClass('disabled').attr('disabled');
                modal.find('.loader').show();
            };

            let hideLoader = function() {
                modal.find('.modal-body').removeClass('dimmer active');
                form.removeClass('dimmer-content');
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
                form.find('.custom-file-label').text('Choose file');

                modal.find('.form-create-product :input:not(:button)').each(function(k, v){
                    $(this).removeClass('is-invalid');

                    if(v.type == 'text') v.value = '';
                    if(v.type == 'file') v.value = '';
                    if(v.type == 'number') v.value = '0';
                    if(v.name == 'description') v.value = '';
                });
            };

            let getFormData = function() {
                let data = {};

                // modal.find('.form-create-product :input:not(:button)').each(function(k, v){
                //     data[v.name] = v.value;
                // });

                data = new FormData(form[0]);

                return data;
            };

            $('#input-tags').selectize({
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

            modal.on('show.bs.modal', function (e) {
                clearErrorMessages();
            });

            modal.find('[name=image]').on('change', function(e){
                e.preventDefault();

                let file = $(this).get(0).files[0];

                form.find('.custom-file-label').text(file.name);
            })

            // Create
            $(document).on('click', '#modal-create-product .btn-submit:not(.disabled)', function(e){
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: '{{ url('api/catalog') }}',
                    data: getFormData(),
                    contentType: false,
				    processData: false,
                    beforeSend: function(){
                        showLoader()
                    },
                    error: function (data) {
                        hideLoader();

                        showError(data.responseText);
                        // swal("Whoops!", data.responseJSON.message, "error").then(() => {
                        // });
                    },
                    success: function (data) {
                        hideLoader();

                        modal.hide();
                        swal("Hooray!", "Successfully to create new Product.", "success")
                        .then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection