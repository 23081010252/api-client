<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class SettingsController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        return view('settings.index');
    }

   // SettingsController.php
public function update(Request $request)
{
    $request->validate([
        'api_base_url' => 'required|url',
    ], [
        'api_base_url.required' => 'URL API wajib diisi.',
        'api_base_url.url'      => 'Format URL tidak valid.',
    ]);

    session([
        'api_base_url' => rtrim($request->api_base_url, '/'),
    ]);

    return back()->with('success', 'Pengaturan API berhasil disimpan!');
}
}
