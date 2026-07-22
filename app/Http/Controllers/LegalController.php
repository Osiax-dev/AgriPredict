<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function cgu()
    {
        return view('legal.cgu');
    }

    public function politique()
    {
        return view('legal.politique');
    }

    public function guide()
    {
        return view('legal.guide');
    }
}