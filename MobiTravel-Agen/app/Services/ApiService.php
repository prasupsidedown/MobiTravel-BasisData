<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    protected $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = 'http://localhost:5000/api';
    }
    
    // ============ PENDAFTARAN AGEN ============
    public function registerAgen($data)
{
    try {
        $response = Http::post($this->baseUrl . '/register/agen', $data);
        return $response->json();
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
    
    // ============ LOGIN AGEN ============
    public function loginAgen($email, $password)
    {
        $response = Http::post($this->baseUrl . '/agen/login', [
            'email' => $email,
            'password' => $password
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            Session::put('agen_token', $data['token']);
            Session::put('agen_id', $data['agen']['id']);
            Session::put('agen_nama', $data['agen']['nama']);
            Session::put('agen_nama_agen', $data['agen']['nama_agen']);
            Session::put('agen_email', $data['agen']['email']);
            return ['success' => true];
        }
        
        return ['success' => false, 'message' => $response->json('error')];
    }
    
    // ============ LOGOUT ============
    public function logoutAgen()
    {
        try {
            Http::withToken(Session::get('agen_token'))
                ->post($this->baseUrl . '/agen/logout');
        } catch (\Exception $e) {}
        
        Session::flush();
        return ['success' => true];
    }
    
    // ============ WISATA ============
    public function getWisata()
    {
        try {
            $response = Http::withToken(Session::get('agen_token'))
                ->get($this->baseUrl . '/agen/wisata');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {}
        return [];
    }
    
    public function createWisata($data)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->post($this->baseUrl . '/agen/wisata', $data);
        return $response->json();
    }
    
    public function updateWisata($id, $data)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->put($this->baseUrl . '/agen/wisata/' . $id, $data);
        return $response->json();
    }
    
    public function deleteWisata($id)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->delete($this->baseUrl . '/agen/wisata/' . $id);
        return $response->json();
    }
    
    // ============ TRIPS ============
    public function getTrips()
    {
        try {
            $response = Http::withToken(Session::get('agen_token'))
                ->get($this->baseUrl . '/agen/trips');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {}
        return [];
    }
    
    public function createTrip($data)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->post($this->baseUrl . '/agen/trips', $data);
        return $response->json();
    }
    
    public function updateTrip($id, $data)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->put($this->baseUrl . '/agen/trips/' . $id, $data);
        return $response->json();
    }
    
    public function deleteTrip($id)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->delete($this->baseUrl . '/agen/trips/' . $id);
        return $response->json();
    }
    
    // ============ BOOKINGS ============
    public function getBookings()
    {
        try {
            $response = Http::withToken(Session::get('agen_token'))
                ->get($this->baseUrl . '/agen/bookings');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {}
        return [];
    }
    
    // ============ AKUN AGEN ============
    public function updateProfile($data)
    {
        $response = Http::withToken(Session::get('agen_token'))
            ->put($this->baseUrl . '/agen/profile', $data);
        
        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['agen'])) {
                Session::put('agen_nama', $result['agen']['nama']);
                Session::put('agen_nama_agen', $result['agen']['nama_agen']);
                Session::put('agen_email', $result['agen']['email']);
            }
            return ['success' => true];
        }
        
        return ['success' => false, 'message' => $response->json('error')];
    }
}