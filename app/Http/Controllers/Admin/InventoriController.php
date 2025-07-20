<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class InventoriController extends Controller
{
    public function index()
    {
        return view('admin.inventori');
    }
}
