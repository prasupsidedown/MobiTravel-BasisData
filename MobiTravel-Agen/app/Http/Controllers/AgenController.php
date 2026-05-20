<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AgenController extends Controller
{
    protected $api;
    
    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }
    
    public function dashboard()
    {
        $wisatas = $this->api->getWisata();
        $trips = $this->api->getTrips();
        $bookings = $this->api->getBookings();
        
        return view('dashboard-agen', [
            'wisatas' => $wisatas,
            'trips' => $trips,
            'bookings' => $bookings
        ]);
    }
    
    // TRIP CRUD
    public function tambahTrip(Request $request)
    {
        $result = $this->api->createTrip([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga
        ]);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Trip berhasil ditambahkan');
        }
        return back()->with('error', $result['message'] ?? 'Gagal menambah trip');
    }
    
    public function editTrip(Request $request)
    {
        $result = $this->api->updateTrip($request->id, [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga
        ]);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Trip berhasil diupdate');
        }
        return back()->with('error', $result['message'] ?? 'Gagal update trip');
    }
    
    public function hapusTrip($id)
    {
        $result = $this->api->deleteTrip($id);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Trip berhasil dihapus');
        }
        return back()->with('error', $result['message'] ?? 'Gagal hapus trip');
    }
    
    // WISATA CRUD
    public function tambahWisata(Request $request)
    {
        $result = $this->api->createWisata([
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori
        ]);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Wisata berhasil ditambahkan');
        }
        return back()->with('error', $result['message'] ?? 'Gagal menambah wisata');
    }
    
    public function editWisata(Request $request)
    {
        $result = $this->api->updateWisata($request->id, [
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga
        ]);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Wisata berhasil diupdate');
        }
        return back()->with('error', $result['message'] ?? 'Gagal update wisata');
    }
    
    public function hapusWisata($id)
    {
        $result = $this->api->deleteWisata($id);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Wisata berhasil dihapus');
        }
        return back()->with('error', $result['message'] ?? 'Gagal hapus wisata');
    }
    
    public function updateAkun(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'nama_agen' => $request->nama_agen,
            'email' => $request->email
        ];
        
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        
        $result = $this->api->updateProfile($data);
        
        if ($result['success'] ?? false) {
            return back()->with('success', 'Akun berhasil diupdate');
        }
        return back()->with('error', $result['message'] ?? 'Gagal update akun');
    }
}