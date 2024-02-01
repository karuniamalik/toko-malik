@extends('layouts.admin')
@section('title')
  Edit User
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
              src="/images/icon-user.png"
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
              <h2 class="dashboard-title">Edit User</h2>
              <p class="dashboard-subtitle">Edit New User</p>
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
                      <form action="{{ route('user.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                          <div class="col-md-12">
                        <div class="form-group">
                              <label for="">Nama User</label>
                              <input type="text" name="name" class="form-control" required value="{{ $item->name }}">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Email</label>
                              <input type="email" name="email" class="form-control" required value="{{ $item->email }}">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Password</label>
                              <input type="password" name="password" class="form-control">
                              <small>Kosongkan jika tidak ingin mengganti password</small>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Roles</label>
                              <select name="roles" id="" required class="form-control">
                                <option value="{{ $item->roles }}" selected>Tidak di ganti</option>
                                <option value="ADMIN">Admin</option>
                                <option value="USER">User</option>
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col text-right">
                              <button type="submit" class="btn btn-success px-5">
                                Update Now
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


