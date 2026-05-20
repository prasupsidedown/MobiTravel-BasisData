<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AuthController extends Controller
{
    protected $api;
    
    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }
    
    public function showLogin()
    {
        return view('login');
    }
    
    public function showRegisterAgen()
    {
        return view('register-agen');
    }
    
    public function registerAgen(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required',
            'nama_agen' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'no_hp' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'jenis_usaha' => 'required',
        ]);
        
        // Kirim ke API Node.js
        $response = $this->api->registerAgen($request->all());
        
        if (isset($response['success']) && $response['success']) {
            return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi admin.');
        }
        
        return back()->with('error', $response['error'] ?? 'Gagal mendaftar');
    }
    
    public function loginAgen(Request $request)
    {
        $result = $this->api->loginAgen($request->email, $request->password);
        
        if ($result['success']) {
            return redirect('/dashboard')->with('success', 'Selamat datang!');
        }
        
        return back()->with('error', $result['message'] ?? 'Login gagal');
    }
    
    public function logout()
    {
        $this->api->logoutAgen();
        return redirect('/login')->with('success', 'Anda telah keluar');
    }


    
}