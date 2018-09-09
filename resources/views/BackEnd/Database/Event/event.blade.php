@extends('adminlte::page')

@section('title', 'Eventq - Event Database')

@section('content')
    <div class="content">
        <section class="content-header">
            <h1>
                Event<br>
                <small style="padding-left: 0">Registered Event</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?= url('dashboard')?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-file-text-o"></i> Event
                    </a>
                </li>
            </ol>
        </section>

        <section class="content container-fluid main-content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Event</b></h3>
                        </div>
                        <div class="box-body" style="padding: 10px 30px">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ url('/admin/event/add') }}" class="btn btn-primary">Add an Event</a>
                                </div>
                            </div>
                            <br>
                            <!-- <hr style="border-style: dashed; border-width: 0.8px; border-color: gray"> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-bordered table-striped table-hover" id="laporanEvent" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <td width="50">No.</td>
                                                <td>Nama Event</td>
                                                <td>Address</td>
                                                <td>Harga</td>
                                                <td>Kuota</td>
                                                <td>Tanggal Mulai</td>
                                                <td>Tanggal Akhir</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modal-info" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Detail Event</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 100px;">Nama Event</th>
                                <td id="v1"></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td id="v2"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td id="v3"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td id="v4"></td>
                            </tr>
                            <tr>
                                <th>Quota</th>
                                <td id="v5"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="v6"></td>
                            </tr>
                            <tr>
                                <th>Confirmation Date</th>
                                <td id="v7"></td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td id="v9"></td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td id="v8"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('js')
    <script type="text/javascript">

        var FormData;

        $(document).ready(function() {
            var tableLaporan = $('#laporanEvent').DataTable({
                "sDom":"ltipr",
                "lengthMenu": [[10, 50, 100, 200, -1], [10, 50, 100, 200, "All"]],
                "scrollX": true,
                "scrollY": true,
                "language": {
                    "lengthMenu": "Tampil _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data kosong",
                    "infoFiltered": "(difilter dari total _MAX_ data)",
                    "search": "Cari :",
                },
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= url('/admin/event/data_table')?>",
                    "type": "GET",
                },
                "columnDefs": [
                    {
                        class: "text-center",
                        width: 30,
                        "targets": [0],
                        "orderable": false,
                        render: function(data, type, row, meta){
                            return meta.row+meta.settings._iDisplayStart+1
                        }
                    },
                    {
                        "targets": [1],
                        "data": "name",
                        width: 90,
                        "orderable": true,
                    },
                    {
                        class: "text-center",
                        "orderable": false,
                        "targets": [2],
                        "data": "address"
                    },
                    {
                        class: "text-center",
                        "orderable": false,
                        "targets": [3],
                        "data": "price"
                    },
                    {
                        class: "text-center",
                        "orderable": false,
                        "targets": [4],
                        "data": "quota"
                    },
                    {
                        class: "text-center",
                        "orderable": false,
                        "targets": [5],
                        "data": "start_date"
                    },
                    {
                        class: "text-center",
                        "orderable": false,
                        "targets": [6],
                        "data": "end_date"
                    },
                    {
                        targets: [7],
                        "sortable": false,
                        "searchable": false,
                        render: function(data, type, row, meta){
                            return "<div class='btn-group'>"+
                                "<a href='{{url("/admin/event/list-peserta")}}/"+row["id"]+"' class='btn btn-info'>Peserta</a>"+
                                "<a href='#' class='btn btn-warning btn-lihat' data-id='"+row.id+"'>Details</a>"+
                                "<a href='{{url("/admin/event/edit")}}/"+row["id"]+"' class='btn btn-primary'>Edit</a>"+
                                "<a href='{{url("/admin/event/delete")}}/"+row["id"]+"' class='btn btn-danger'>Hapus</a>"+
                                "</div>";
                        }
                    }
                ],
            });

            tableLaporan.draw();

            $(document).on('click', '.btn-lihat',function(){
                let dis = $(this);
                $.ajax({
                    url: '{{ url('/admin/event/get-detail') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: dis.attr('data-id')
                    },
                    success: function(res){
                        console.log(res)
                        $('#v1').text(res.event.name)
                        $('#v2').text(res.event.category)
                        $('#v3').text(res.event.address)
                        $('#v4').text(res.event.price)
                        $('#v5').text(res.event.quota)
                        $('#v6').text(res.event.description)
                        $('#v7').text(res.event.confirmation_date)
                        $('#v8').html("<img src='{{ asset("Images/Event/") }}/"+res.event.photo+"' style='width:200px'>")
                        $('#v9').text(res.event.regencies)
                        $('#modal-info').modal('show')
                    }
                })
            })
        });
    </script>
@stop
