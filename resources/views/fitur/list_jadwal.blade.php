@extends('app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Tables</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Jadwal Saya</a>
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
                    <h5>Jadwal Saya</h5>
                </div>
                <div class="ibox-content" style=" min-height: calc(100vh - 244px); ">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Ujian</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam</th>
                                    <th class="text-center">Link</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">{{$loop->index +1}}</td>
                                    <td class="text-center">{{$item["jenis"]}}</td>
                                    <td class="text-center">{{$item["tanggal"]}}</td>
                                    <td class="text-center">{{$item["waktu"]}}</td>
                                    <td class="text-center">{{$item["link"] == null ? "Belum ada link" : $item["link"]}}</td>
                                    <td class="text-center">
                                        <form action="hapus_ujian" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item['id_list']}}">
                                            <input type="hidden" name="tes" value="{{$item['jenis']}}">
                                            <input type="hidden" name="jadwal" value="{{$item['id_jadwal']}}">
                                            <button class="btn btn-danger" type="submit" onclick="confirm('Apakah anda yakin?')"> Hapus</button>
                                        </form>
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
@endsection