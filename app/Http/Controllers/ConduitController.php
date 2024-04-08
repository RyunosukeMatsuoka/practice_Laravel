<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConduitController extends Controller
{
    /**
     * 記事一覧を表示
     * @return view
     */
    public function showList()
    {
        return view('conduit.home');
    }
}
