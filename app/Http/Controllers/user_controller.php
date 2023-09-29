<?php

namespace App\Http\Controllers;

use App\Models\jadwal;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use SpreadsheetReader;

// use SpreadsheetReader;
// use SpreadsheetReader;
require 'excel/SpreadsheetReader.php';

use Exception;
use Illuminate\Support\Facades\Hash;

class user_controller extends Controller
{
    public function tampil_login()
    {
        return view('Auth.login');
    }

    public function tampil_profil()
    {
        $loc = "";
        return view('fitur.profil', [
            'loc' => $loc
        ]);
    }

    public function login(Request $request)
    {
        // dd(Admin::bersih($request->input('username')));
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];


        Auth::attempt($data);
        // dd(Auth::user());
        // echo Auth::user()->username;
        if (Auth::attempt($data)) { // true sekalian session field di users nanti bisa dipanggil via Auth
            // echo "Login Success";
            return redirect('/dashboard');
        } else { // false
            //Login Fail
            return redirect('/login')->with('message', 'Username atau password salah');
        }
    }

    public function upload_berkas(Request $request)
    {
        // Create a new record
        $record = User::find(Auth::user()->id);

        // Handle file uploads for field1
        if ($request->hasFile('berkas_ktp')) {
            $file = $request->file('berkas_ktp');
            $exten = $file->getClientOriginalExtension();
            $nama = 'KTP_' . Auth::user()->nama . '_' . substr($request['tanggal'], 0, 10) . '.' . $exten;
            $tujuan_upload = 'ktp/';
            $file->move($tujuan_upload, $nama);
            $record->berkas_ktp = $nama;
        }

        if ($request->hasFile('berkas_komit')) {
            $file = $request->file('berkas_komit');
            $exten = $file->getClientOriginalExtension();
            $nama = 'Komitmen_' . Auth::user()->nama . '_' . substr($request['tanggal'], 0, 10) . '.' . $exten;
            $tujuan_upload = 'komitmen/';
            $file->move($tujuan_upload, $nama);
            $record->berkas_komit = $nama;
        }

        if ($request->hasFile('berkas_lpj')) {
            $file = $request->file('berkas_lpj');
            $exten = $file->getClientOriginalExtension();
            $nama = 'LPJ_' . Auth::user()->nama . '_' . substr($request['tanggal'], 0, 10) . '.' . $exten;
            $tujuan_upload = 'lpj/';
            $file->move($tujuan_upload, $nama);
            $record->berkas_lpj = $nama;
        }

        if ($request->hasFile('berkas_lulus')) {
            $file = $request->file('berkas_lulus');
            $exten = $file->getClientOriginalExtension();
            $nama = 'Lulus_' . Auth::user()->nama . '_' . substr($request['tanggal'], 0, 10) . '.' . $exten;
            $tujuan_upload = 'lulus/';
            $file->move($tujuan_upload, $nama);
            $record->berkas_lulus = $nama;
        }
        // Save the record
        $record->berkas_status = 1;
        $record->save();
        return redirect('dashboard');
    }

    public function terima_berkas($id)
    {
         // Create a new record
         $record = User::find($id);
         $record->berkas_status = 3;
         $record->save();
         
         return redirect()->back();
    }

    public function tolak_berkas($id)
    {
         // Create a new record
         $record = User::find($id);
         $record->berkas_status = 2;
         $record->save();

         return redirect()->back();
    }
    

    public function tambah_peserta(Request $req)
    {
        // echo "masuk";

        $file = $req->file('excel');
        $exten = $file->getClientOriginalExtension();
        $nama = 'coba'. '.' . $exten;
        $tujuan_upload = 'data/';
        $file->move($tujuan_upload, $nama);
        try {
            $Spreadsheet = new SpreadsheetReader($tujuan_upload . $nama);
            // dd($Spreadsheet);
            // $Sheets = $Spreadsheet -> Sheets();		

            foreach ($Spreadsheet as  $Row) {
                // echo $Key.': ';
                // dd($Row);
                if ($Row) {
                    $data = [
                        'nama' => $Row[4],
                        'no_hp' => $Row[6],
                        'tema' => $Row[1],
                        'kampus' => $Row[2],
                        'no_peserta' => $Row[3],
                        'email' => $Row[5],
                        'az' => $Row[7] == 'YA' ? true : false,
                        'dp' => $Row[8]  == 'YA' ? true : false,
                        'ai' => $Row[9]  == 'YA' ? true : false,
                        'berkas_status' => 0,
                        'level' => 1,
                        'password' => bcrypt("akunbaru"),
                    ];
                    // dd($data)
                    $user = new User();
                    $user->nama = ucwords(strtolower($Row[4]));
                    $user->kampus = $Row[2];
                    $user->tema = $Row[1];
                    $user->no_peserta = $Row[3];
                    $user->no_hp = $Row[6];
                    $user->email = $Row[5];
                    $user->AZ = $Row[7] == 'YA' ? true : false;
                    $user->DP = $Row[8] == 'YA' ? true : false;
                    $user->AI = $Row[9] == 'YA' ? true : false;
                    $user->level = 1;
                    $user->berkas_status = 0;
                    $user->password = bcrypt("akunbaru");
                    $user->save();


                    // echo $Row[0];
                    // echo "[0]";
                    // echo $Row[1];
                    // echo "[1]";
                    // echo $Row[2];
                    // echo "[2]";
                    // echo $Row[3];
                    // echo "[3]";
                    // echo $Row[4];
                    // echo "[4]";
                    // echo $Row[5];
                    // echo "[5]";
                    // echo $Row[6];
                    // echo "[6]";
                    // echo $Row[7];
                    // echo "[7]";
                    // echo $Row[8];
                    // echo "[8]";
                    // echo $Row[9];
                    // echo "[9]";
                    // echo "<br>";
                    // return "bisa";
                } else {
                    echo "kosong";
                    // return "tidak";
                }
            }
        } catch (Exception $E) {
            echo $E->getMessage();
        }
        // return redirect("/list_peserta");
    }

    public function dashboard()
    {
        $loc = "dashboard";
        $user = [
            'berkas_ktp' => Auth::user()['berkas_ktp'],
            'berkas_komit' => Auth::user()['berkas_komit'],
            'berkas_lulus' => Auth::user()['berkas_lulus'],
            'berkas_lpj' => Auth::user()['berkas_lpj'],
        ];
        // dd($user);
        $data = jadwal::all();
        return view("fitur.dashboard", compact("loc", "data","user"));
    }

    public function filter(Request $req)
    {
        $loc = "dashboard";
        if ($req['jenis'] == 'all') {
            $data = jadwal::all()->where('tanggal', $req['waktu']);
        } else {
            $data = jadwal::all()->where('jenis', $req['jenis'])
                ->where('tanggal', $req['waktu']);
        }

        return view("fitur.dashboard", compact("loc", "data"));
    }

    public function list_peserta()
    {
        $loc = "list_peserta";
        $data = User::all()->where("level", 1);
        return view("fitur.list_peserta", compact("loc", "data"));
    }


    public function tampil_ganti_password()
    {
        return view('auth.ganti_password');
    }

    public function ganti_password(Request $req)
    {
        if (Hash::check($req['lama'], Auth::user()->password)) {
            $id = Auth::user()->id;
            $user = User::all()->where("id", $id)->first()->update([
                'password' => Hash::make($req['baru']),
            ]);
        } else {
            return redirect('/ganti_password')->with('status', 'Kata sandi lama anda salah!');
        }

        return redirect('/dashboard')->with('success', 'Password berhasil diganti!');
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect('login');
    }
}
