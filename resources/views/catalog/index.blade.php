@extends('template')

@section('title', $title)

@section('content')
<div class="my-3 my-md-5">
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">
        Catalogs
      </h1>
      <div class="page-subtitle">Total of {{ $catalogs->count() }} Products</div>
      <div class="page-options d-flex">
        <div class="input-icon mr-2">
          <a href="#" class="btn btn-lime" data-toggle="modal" data-target="#modal-create-product"><i class="fas fa-plus" title="price"></i> Add New</a>
        </div>
        <select class="form-control custom-select w-auto">
          <option value="asc">Newest</option>
          <option value="desc">Oldest</option>
        </select>
        <div class="input-icon ml-2">
          <span class="input-icon-addon">
            <i class="fe fe-search"></i>
          </span>
          <input type="text" class="form-control w-10" placeholder="Search product">
        </div>
      </div>
    </div>
    <div class="row row-cards">
      @foreach($catalogs as $catalog)
      <div class="col-sm-6 col-lg-4">
        <div class="card p-3">
          <a href="javascript:void(0)" class="mb-3">
            <img src="{{ url('catalog/image') . '/' . $catalog->image . '/sm' }}" alt="Photo by Nathan Guerrero" class="rounded">
          </a>
          <div class="d-flex align-items-center px-3 mb-3">
            <div>
            {{ $catalog->name }}
            </div>
          </div>
          <div class="d-flex align-items-center px-2">
            <div>
              <small class="d-block text-muted">12 days ago</small>
            </div>
            <div class="ml-auto text-muted">
              <a href="javascript:void(0)" class="icon"><i class="fas fa-dollar-sign" title="price"></i> {{ $catalog->price }}</a>
              <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3" title="stock"><i class="fas fa-shopping-bag"></i> {{ $catalog->stock }}</a>
            </div>
          </div>
          <div class="card-footer mt-3">
              <a href="#" class="btn btn-primary"><i class="fas fa-shopping-bag" title="price"></i> Add Stock</a>
              <a href="#" class="btn btn-primary"><i class="fas fa-percentage" title="price"></i> Add Discount</a>
              <a href="#" class="btn btn-danger"><i class="fas fa-time" title="price"></i> Delete</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="loader" style="padding-right: 100%; z-index:1;"></div>
  </div>
</div>

@include('catalog._modal_create')

@endsection

@section('js')
    <script>
        require(['jquery'], function( $ ) {
            let count = {{ $catalogs->count() }};

            if(count < 12){
              $('.loader').hide();
            }

            // load more on scroll
            let load_on_scroll = function(){
                console.log('scroll count: ' + count);
            };

            load_on_scroll();
        });
    </script>
@endsection