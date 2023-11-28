<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return '<h1>Selamat Datang</h1> <br> Ini Adalah Halaman Dashboard';
    }
}