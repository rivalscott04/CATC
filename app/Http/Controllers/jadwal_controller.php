<?php

namespace App\Http\Controllers;

use App\Models\jadwal;
use App\Models\listjadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class jadwal_controller extends Controller
{
    public function list_jadwal () {
         $data = listjadwal::join('jadwals', 'listjadwals.id_jadwal', '=', 'jadwals.id_jadwal')
        ->join('users', 'listjadwals.id_peserta', '=', 'users.id')
        ->select('users.*', 'jadwals.*', 'listjadwals.id_list')
        ->where('id', Auth::user()->id)
        ->get();
        // dd($data);
        $loc = "list_jadwal";
        return view('fitur.list_jadwal', compact("data","loc"));
    }

    
    public function tambah_jadwal(Request $req) {
        $data = [
            "tanggal" => $req["tanggal"],
            "waktu" => $req["jam"],
            "jenis" => $req["tes"],
            "kuota" => $req["kuota"],
        ];

        jadwal::create($data);
        return redirect("/dashboard");
    }

    public function hapus_jadwal(Request $req) {
        jadwal::all()->where('id', $req["id"])->each->delete();
        // jadwal::create($data);
        return redirect("/dashboard");
    }

    public function hapus_ujian(Request $req) {
        listjadwal::all()->where('id_list', $req["id"])->each->delete();
        // jadwal::create($data);
        // dd($req);
        if ($req['tes'] =="AZ") {
            User::all()->where('id', Auth::user()->id)->first()->update(
                ["az" => 1]
            );
        }
        if ($req['tes'] =="AI") {
            User::all()->where('id', Auth::user()->id)->first()->update(
                ["ai" => 1]
            );
        }
        if ($req['tes'] =="DP") {
            User::all()->where('id', Auth::user()->id)->first()->update(
                ["dp" => 1]
            );
        }
        jadwal::increment('kuota', 1, ['id_jadwal' => $req['jadwal']]);
        return redirect("/dashboard");
    }

    public function simpan_jadwal(Request $req) {
        $data = [
            "id_peserta" => $req['peserta'],
            "id_jadwal" => $req['jadwal']
        ];
        // dd($data);
        if ($req['tes'] =="AZ") {
            User::all()->where('id', $req->peserta)->first()->update(
                ["az" => 0]
            );
        }
        if ($req['tes'] =="AI") {
            User::all()->where('id', $req->peserta)->first()->update(
                ["ai" => 0]
            );
        }
        if ($req['tes'] =="DP") {
            User::all()->where('id', $req->peserta)->first()->update(
                ["dp" => 0]
            );
        }

        jadwal::decrement('kuota', 1, ['id_jadwal' => $req['jadwal']]);
        

        listjadwal::create($data);
        return redirect("dashboard");
    }

    public function jadwal_peserta(Request $req) {
        // dd($req);
        $data = listjadwal::join('jadwals', 'listjadwals.id_jadwal', '=', 'jadwals.id_jadwal')
        ->join('users', 'listjadwals.id_peserta', '=', 'users.id')
        ->select('users.*', 'jadwals.*', 'listjadwals.id_list')
        ->where('jadwals.id_jadwal',$req['id'])->get();
        // dd($data);
        $loc ="dashboard";
        return view("fitur.peserta_ujian", compact("loc", "data"));
    }
}
