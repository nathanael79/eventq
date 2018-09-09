@extends('adminlte::page')

@section('title', 'Eventq - Account Database')

@section('content')
    <div class="content">
        <section class="content-header">
            <h1>
                Add an Account<br>
                <small style="padding-left: 0">Menambah Account Baru</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/home') }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/account') }}">
                        <i class="fa fa-building"></i> Account
                    </a>
                </li>
                <li><i class="fa fa-plus"></i>&nbsp; Tambah</li>
            </ol>
        </section>

        <section class="content container-fluid main-content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary box-centered">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Tambah Akun</b></h3>
                        </div>
                        <div class="box-body">
                            <form class="form-main form-update" action="{{ url('/admin/account/store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="regency">Kota</label>
                                    <br>
                                    <div class="regencies-wrapper" style="width: 400px;">
                                        <select class="select2" name="regency" style="width: 100%">
                                            @foreach ($regency as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama anda" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat / Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Masukkan alamat anda" min="1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email anda" required="">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password anda" required="">
                                </div>
                                <div class="gender-wrapper form-group" style="width: 400px;">
                                    <label for="gender">Gender</label>
                                    <select class="select2" name="gender" style="width: 100%">
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                                <div class="user_role-wrapper form-group" style="width: 400px;">
                                    <label for="user_role">User Role</label>
                                    <select class="select2" name="user_role" style="width: 100%">
                                        <option value="1">Administrator</option>
                                        <option value="0">User</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for=birthdate">Tanggal Lahir</label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="Date"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input name="photo" id="photo" type="file" class="dropify" data-max-file-size="3M" />
                                </div>



                                <a href="{{ url('/admin/event') }}" class="btn btn-lg btn-danger btn-flat"><i class="fa fa-trash-o"></i>&nbsp; Batal</a>
                                <button type="submit" class="btn btn-lg btn-primary btn-flat"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
    // $('#Date').datepicker({
    //     autoclose: true,
    //     todayHighlight: true
    // });
        $(function () {
            $("#Date").datepicker();
        });
    </script>
@stop
