<?php

namespace App\Http\Controllers;

/**
 * Controller dasar yang menjadi induk (parent) dari semua controller lainnya di aplikasi.
 * Penggunaan 'abstract' memastikan bahwa class ini tidak dapat diinstansiasi secara langsung,
 * melainkan harus diwariskan (extends) oleh class controller spesifik lainnya.
 */
abstract class Controller
{
    // Class ini sering digunakan untuk mendefinisikan logic umum, 
    // seperti Trait (misalnya AuthorizesRequests, DispatchesJobs, ValidatesRequests) 
    // yang akan diwariskan ke semua controller turunan.
}