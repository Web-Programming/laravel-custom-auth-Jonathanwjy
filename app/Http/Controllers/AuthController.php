<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        //kita ambil data user lalu simpan di variabel $user
        $user = Auth::user();
        //kondisi jika user ada
        if($user){
            //Jika user memiliki level admin
            if($user->level == 'admin'){
                //arahkan ke halaman admin 
                return redirect()->intented('admin');
            }
            
            //jika user nya memiliki level user
            else if($user->level == 'user'){
                //arahkan ke halaman user
                return redirect()->intended('user');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request){
        // kita buat validasi pada saat tombol login di klik
        // validasi nya username & password wajib di isi
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        // ambil data request username & password saja 
        $credential = $request->only('username','password');

        //cek jika data username dan password valid (sesuai) dengan data
        if(Auth::attempt($credential)){
            //Kalau berhasil simpan data user di variabel $user
            $user = Auth::user();
            //cek jika level user admin maka arahkan ke hal admin
            if($user->level == 'admin'){
                return redirect()->intended('admin');
            }

            //tapi jika level user biasa maka ke hal user
            else if($user->level == 'user'){
                return redirect()->intended('user');
            }

            //jika belum ad role maka ke halaman /
            return redirect()->intended('/');
        }

        //jika tidak ada data user yg valid kembalikan ke hal login\
        //pastikan kirim pesan error jika login gagal
        return redirect('login')->withInput()->withErrors([
            'login_gagal'=>'These Credentials does not match our records'
        ]);
    }

    public function register(){
        //tampilkan view register
        return view('register');
    }

    // aksi form register
      public function proses_register(Request $request){ 
    // kita buat validasi buat proses register
    // validasinya yaitu semua field wajib di isi
    // validasi username itu harus unique atau tidak boleh duplicate username ya
        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'required|email',
            'password'=>'required'
        ]);

        //jika gagal kembali ke halaman register dan munculkan pesan error
        if($validator->fails()){
            return redirect('/register')->withErrors($validator)->withInput();
        }

        //Kalau berhasil isi level dan hash passwordnya agar secure
        $request['level']='user';
        $request['password'] = bcrypt($request->password);

        //masukkan semua data pada request ke table user
        User::create($request->all());
        //kalau berhasil arahkan ke halam login
        return redirect()->route('login');
    }
    public function logout(Request $request){
        //logout
        $request->session()->flush();
        //jalankan juga fungsi logout pada auth
        Auth::logout();
        //kembali ke hal login
        return redirect('login');
    }
}
