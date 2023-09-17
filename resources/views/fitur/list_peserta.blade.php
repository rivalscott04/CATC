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
                                Tambah Peserta</button>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Id registrasi</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">KTP</th>
                                        <th class="text-center">Komitmen</th>
                                        <th class="text-center">Lulus</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $item['nama'] }}</td>
                                            <td class="text-center">{{ $item['no_peserta'] }}</td>
                                            <td class="text-center">{{ $item['email'] }}</td>
                                            <td class="text-center">
                                                @if ($item['berkas_ktp'] != null)
                                                    <button class="btn btn-primary btn-lg">Sudah</button>
                                                @else
                                                    <button class="btn btn-lg btn-danger">Belum</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item['berkas_komit'] != null)
                                                    <button class="btn btn-primary btn-lg">Sudah</button>
                                                @else
                                                    <button class="btn btn-lg btn-danger">Belum</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item['berkas_lulus'] != null)
                                                    <button class="btn btn-primary btn-lg">Sudah</button>
                                                @else
                                                    <button class="btn btn-lg btn-danger">Belum</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#pdf"
                                                    onclick="pdf_view('{{ $item['berkas_ktp'] }}','{{ $item['berkas_komit'] }}','{{ $item['berkas_lulus'] }}')">Lihat</button>
                                            </td>
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

                    <form role="form" method="post" action="/tambah_peserta" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Masukan file data peseta (xls,xlsx)</label>
                            <input class="form-control" type="file" name="excel" id="modalWaktu" autocomplete="off">
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
    <div class="modal inmodal" id="pdf" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button> --}}
                    {{-- <i class="fa fa-laptop modal-icon"></i> --}}
                    
                    <center>
                        <h4 class="modal-title">Proposal</h4>
                        <button class="btn btn-sm btn-danger" id="tolak">Tolak</button>
                        <button class="btn btn-sm btn-primary" id="terima">Terima</button>

                    </center>
                    {{-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> --}}
                </div>
                <div class="modal-body">
                    {{-- <h2>PDF 1 - Title</h2>
                    <div class="embed-responsive embed-responsive-16by9">

                        <iframe class="embed-responsive-item" id="pdf_file" allowfullscreen></iframe>
                    </div>

                    <h2>PDF 1 - Title</h2>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" id="pdf_file2" allowfullscreen></iframe>
                    </div> --}}

                    <div class="pdf-container">
                        <h2>KTP</h2>
                        <iframe class="frame" id="pdf_file" allowfullscreen></iframe>
                    </div>
                    <div class="pdf-container">
                        <h2>Komitmen</h2>
                        <iframe class="frame" id="pdf_file2" allowfullscreen></iframe>
                    </div>
                    <div class="pdf-container">
                        <h2 id="lulus">Keterangan Lulus</h2>
                        <iframe class="frame" id="pdf_file3" allowfullscreen></iframe>
                    </div>
                    {{-- <div class="pdf-container">
                        <h2>PDF 3 - Title</h2>
                        <iframe id="pdf_file" allowfullscreen></iframe>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
