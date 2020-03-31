<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminArticelController extends Controller
{
    //
    function add() {
        return view('admin.editArticle');
    }
}
