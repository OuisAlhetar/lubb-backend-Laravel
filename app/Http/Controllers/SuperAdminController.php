<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard(){
        return ["hello from super-admin dashboard"];
    }
}