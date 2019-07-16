@extends('template')

@section('title', $title)

@section('content')
<div class="my-3 my-md-5" style="min-height:480px;">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">
        Categories
      </h1>
      <div class="page-options d-flex">
        <div class="input-icon mr-2">
          <a href="#" class="btn btn-lime" 
              data-toggle="modal" 
              data-target="#modal-create-category"
              data-create="category">
                <i class="fas fa-plus" title="price"></i> Add Category
            </a>
        </div>
      </div>
    </div>
    <div class="row row-cards row-deck">
        @foreach($category as $cat)
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="#" title="edit" 
                            data-toggle="modal" 
                            data-target="#modal-edit-category" 
                            data-update="category"
                            data-id="{{ $cat->id }}">{{ $cat->name }}</a>
                    </h3>
                    <div class="card-options">
                      <a href="#" class="card-options-pin {{ $cat->pinned ? 'text-green' : 'text-gray' }}" data-id="{{ $cat->id }}"><i class="fas fa-tag"></i></a>
                      <a href="#" class="card-options-delete text-red" data-id="{{ $cat->id }}"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
                <div class="card-body o-auto" style="height: 15rem">
                <ul class="list-unstyled list-separated">
                    <li class="list-separated-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="mb-2 add-subcategory-column">
                                <a href="javascript:void(0)" 
                                    class="text-inherit text-green" 
                                    data-toggle="modal" 
                                    data-target="#modal-create-category"
                                    data-parent-id="{{ $cat->id }}"
                                    data-depth="{{ $cat->depth }}"
                                    data-create="subcategory">
                                    
                                    <i class="fas fa-plus" title="price"></i> Add subcategory
                                </a>
                            </div>
                            @foreach($cat->childrens as $subcat)
                            <div class="subcategory-name">
                                <table class="tbl-subcategory-info" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td width="80%">
                                                <a href="#" title="edit" 
                                                    style="color:#495057" 
                                                    data-toggle="modal" 
                                                    data-target="#modal-edit-category" 
                                                    data-update="subcategory"
                                                    data-id="{{ $subcat->id }}"><span>{{ $subcat->name }}</span>
                                                </a>
                                            </td>
                                            <td style="text-align:right">
                                                <small><a href="#" class="card-options-pin {{ $subcat->pinned ? 'text-green' : 'text-gray' }}" data-id="{{ $subcat->id }}"><i class="fas fa-tag"></i></a></small>
                                                <small><a href="#" class="card-options-delete text-red" data-id="{{ $subcat->id }}"><i class="fas fa-trash"></i></a></small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="d-block item-except text-sm text-muted h-2x mt-1 ml-2">
                                <a href="javascript:void(0)" class="text-inherit text-green" 
                                    data-toggle="modal" 
                                    data-target="#modal-create-category"
                                    data-parent-id="{{ $subcat->id }}"
                                    data-depth="{{ $subcat->depth }}"
                                    data-create="subcontent">
                                        <i class="fas fa-plus" title="price"></i> Add subcontent
                                </a>
                            </small>
                            <table class="tbl-subcontent-info ml-5" style="width:95%">
                                <tbody>
                                    @foreach($subcat->childrens as $content)
                                    <tr>
                                        <td width="80%">
                                            <a href="#" title="edit" 
                                                style="color:#495057" 
                                                data-toggle="modal" 
                                                data-target="#modal-edit-category" 
                                                data-update="subcontent"
                                                data-id="{{ $content->id }}">
                                                    <small class="d-block item-except text-sm text-muted h-1x">{{ $content->name }}</small>
                                            </a>
                                        </td>
                                        <td style="text-align:right">
                                            <small><a href="#" class="card-options-pin {{ $content->pinned ? 'text-green' : 'text-gray' }}" data-id="{{ $content->id }}"><i class="fas fa-tag"></i></a></small>
                                            <small><a href="#" class="card-options-delete text-red" data-id="{{ $content->id }}"><i class="fas fa-trash"></i></a></small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr/>
                            @endforeach
                        </div>
                    </div>
                    </li>
                </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('category._modal_create')
@include('category._modal_update')

@endsection

@section('js')
<script>
    require(['jquery', 'swal'], function( $ ) {
        $(document).on('click', '.card-options-pin', function(e){
            e.preventDefault();

            let id = $(this).data('id');
            let content = $(this);
            let text = 'pinned';

            $.ajax({
                    type: "PUT",
                    url: '{{ url('api/category') }}' + '/' + id + '/pinned',
                    beforeSend: function(){
                        // showLoader()
                    },
                    error: function (data) {
                        swal("Whoops!", data.responseJSON.message, "error").then(() => {
                            // showError(data.responseText);
                        });
                    },
                    success: function () {
                        if(content.hasClass('text-green')) text = 'unpin';

                        swal("Hooray!", "Successfully to " + text + " this category.", "success")
                        .then(() => {
                            content.toggleClass('text-green text-gray');
                        });
                    }
                });
        });

        $(document).on('click', '.card-options-delete', function(e){
            e.preventDefault();

            let id = $(this).data('id');

            swal({
                title: "Delete category",
                text: "Are you sure want to delete this category ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((ok) => {
                    if (ok) {
                        $.ajax({
                            type: "DELETE",
                            url: '{{ url('api/category') }}/' + id,
                            error: function () {
                                swal("Whoops!", "Unable to delete category.", "error")
                            },
                            success: function () {
                                swal("Success! Category has been deleted!", {
                                    icon: "success",
                                }).then(()=>{
                                    location.reload();
                                });
                            }
                        });
                    }
                });
        });
    });
</script>
@endsection