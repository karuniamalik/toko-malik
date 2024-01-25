@extends('layouts.admin')
@section('title')
  Create Product
@endsection
@section('content')
<div id="page-content-wrapper">
  <nav class="navbar navbar-store navbar-expand-lg navbar-light fixed-top"
    data-aos="fade-down">
    <button class="btn btn-secondary d-md-none mr-auto mr-2"
      id="menu-toggle">
      &laquo; Menu
    </button>

    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto d-none d-lg-flex">
        <li class="nav-item dropdown">
          <a
            class="nav-link"
            href="#"
            id="navbarDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img
              src="/images/icon-product.png"
              alt=""
              class="rounded-circle mr-2 profile-picture"
            />
            Hi, Angga
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
            <a class="dropdown-item" href="/">Logout</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link d-inline-block mt-2" href="#">
            <img src="/images/icon-cart-empty.svg" alt="" />
          </a>
        </li>
      </ul>
      <!-- Mobile Menu -->
      <ul class="navbar-nav d-block d-lg-none mt-3">
        <li class="nav-item">
          <a class="nav-link" href="#"> Hi, Angga </a>
        </li>
        
      </ul>
    </div>
  </nav>

  <div
      class="section-content section-dashboard-home"
      data-aos="fade-up"
    >
        <div class="container-fluid">
            <div class="dashboard-heading">
              <h2 class="dashboard-title">Create Product</h2>
              <p class="dashboard-subtitle">Create New Product</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-12">
                     @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    <div class="card">
                      <div class="card-body">
                      <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12">
                           
                            <div class="form-group">
                              <label for="">Nama Product</label>
                              <input type="text" name="name" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Pemilik Product</label>
                            <select name="users_id" class="form-control" id="">
                              @foreach ($users as $user )
                                
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Kategori Product</label>
                            <select name="categories_id" class="form-control" id="">
                              @foreach ($categories as $category )
                                
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Harga Product</label>
                           
                              <input type="number" name="price" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Deskripsi Product</label>
                           <textarea name="description" id="editor" >

                           </textarea>
                             
                            </div>
                          </div>
                         
                          
                          <div class="row">
                            <div class="col text-right">
                              <button type="submit" class="btn btn-success px-5">
                                Save Now
                              </button>
                            </div>
                          </div>

                        </div>

                      </form>
                       
                      </div>
                    </div>
                  </div>
                </div>


          </div>
      </div>
  </div>
</div>
@endsection

@push('addon-script')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
                        ClassicEditor
                                .create( document.querySelector( '#editor' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
@endpush


