@extends('app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Data Tables</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Daftar Peserta</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Tables</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Peserta CATC</h5>
                    </div>
                    <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">
                        @if (Auth::user()->level == 0)
                            <button class="btn btn-lg btn-primary mb-3 mt-1" data-toggle="modal" data-target="#myModal">
                                Tambah Link Ujian</button>
                            @if ($link['link'] == null)
                                <p class="btn-info btn-lg float-right">Belum ada link</p>
                            @else
                                <p class="btn-lg btn-primary float-right text-black">{{ 'Link: '. $link['link']  }}</p>
                            @endif
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Id registrasi</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Ujian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $item['nama'] }}</td>
                                            <td class="text-center">{{ $item['no_peserta'] }}</td>
                                            <td class="text-center">{{ $item['email'] }}</td>
                                            <td class="text-center">{{ $item['jenis'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="myModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Tambah Jadwal</h4>
                </div>
                <div class="modal-body bg-white">

                    <form role="form" method="post" action="/add_link">
                        @csrf
                        <div class="form-group">
                            <label>Masukan file data peseta (xls,xlsx)</label>
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input class="form-control" type="text" name="excel" id="modalWaktu" autocomplete="off">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?')">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
