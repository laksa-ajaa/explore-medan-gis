<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $this->data['teams'] = Member::all();
        return view('pages.web.index', $this->data);
    }
}
