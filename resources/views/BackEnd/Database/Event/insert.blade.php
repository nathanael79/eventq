@extends('adminlte::page')

@section('title', 'Eventq - Event Database')

@section('content')
    <div class="content">
        <section class="content-header">
            <h1>
                Add an Event<br>
                <small style="padding-left: 0">Menambah Event Baru</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/home') }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/event') }}">
                        <i class="fa fa-building"></i> Event
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
                            <h3 class="box-title"><b>Tambah data event</b></h3>
                        </div>
                        <div class="box-body">
                            <form class="form-main form-update" action="{{ url('/event/store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <br>
                                    <div class="status-wrapper" style="width: 400px;">
                                        <select class="select2" name="status" style="width: 100%">
                                            <option value="Published">Published</option>
                                            <option value="Unpublised">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <br>
                                    <div class="kategori-wrapper" style="width: 400px;">
                                        <select class="select2" name="category_id" style="width: 100%">
                                            @foreach ($category as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Acara</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama acara" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat / Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Masukkan alamat acara" min="1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="regency">Kota</label>
                                    <br>
                                    <div class="regency-wrapper" style="width: 400px;">
                                        <select class="select2" name="regency_id" style="width: 100%">
                                            @foreach ($regency as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Biaya</label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Masukkan biaya" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="quota">Kuota</label>
                                    <input type="number" class="form-control" name="quota" id="quota" placeholder="Masukkan kuota peserta" min="1">
                                </div>
                                <div class="form-group">
                                    <br>
                                    <label for="birthdate">Start Date</label>
                                    <br>
                                    <div class="col-md-10">
                                        <div class="input-group" id='datetimepicker1'>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="start_date" type="text" class="form-control date" data-format="dd/MM/yyyy hh:mm:ss"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br>
                                    <label for="birthdate">End Date</label>
                                    <br>
                                    <div class="col-md-10">
                                        <div class="input-group" id='datetimepicker2'>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="end_date" type="text" class="form-control date2" data-format="dd/MM/yyyy hh:mm:ss"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <br>
                                    <br>
                                    <label for="description">Deskripsi</label>
                                    <br>
                                    <textarea class="form-control" name="description" id="description" placeholder="Masukkan deskripsi acara" required="" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">Confirmation Date</label>
                                    <div class="col-md-10">
                                        <div class="input-group date" id='datetimepicker3'>
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="confirmation_date" type="text" class="form-control date3" date-format="dd/MM/yyyy hh:mm:ss"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Gambar</label>
                                    <input name="photo" id="photo" type="file" class="dropify" data-max-file-size="3M" />
                                </div>
                                <a href="{{ url('/event') }}" class="btn btn-lg btn-danger btn-flat"><i class="fa fa-trash-o"></i>&nbsp; Batal</a>
                                <button type="submit" class="btn btn-lg btn-primary btn-flat"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection