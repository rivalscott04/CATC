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

class user_controller extends Controller
{
    public function tampil_login()
    {
        return view('Auth.login');
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

    public function tambah_peserta(Request $req)
    {
        // echo "masuk";

        $file = $req->file('excel');
        $exten = $file->getClientOriginalExtension();
        $nama = $req['nama'] . '_' . substr($req['tanggal'], 0, 10) . '.' . $exten;
        $tujuan_upload = 'data/';
        $file->move($tujuan_upload, $nama);
        try {
            $Spreadsheet = new SpreadsheetReader($tujuan_upload.$nama);
            // dd($Spreadsheet);
            // $Sheets = $Spreadsheet -> Sheets();		

            foreach ($Spreadsheet as  $Row) {
                // echo $Key.': ';
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
                        'level' => 0,
                        'password' => bcrypt("akunbaru"),
                    ];
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
        return redirect("/list_peserta");
    }

    public function dashboard() {
        $loc = "dashboard";
        $data = jadwal::all();
        return view("fitur.dashboard", compact("loc","data"));
    }

    public function filter(Request $req) {
        $loc = "dashboard";
        $data = jadwal::all()->where('jenis', $req['jenis'])
        ->where('tanggal', $req['waktu']);
        return view("fitur.dashboard", compact("loc","data"));
    }

    public function list_peserta() {
        $loc = "list_peserta";
        $data = User::all()->where("level", 1);
        return view("fitur.list_peserta", compact("loc","data"));
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect('login');
    }
}
