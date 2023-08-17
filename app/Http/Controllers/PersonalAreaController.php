<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use Illuminate\Support\Facades\Auth;

class PersonalAreaController extends Controller
{
    public function index()
    {
        $abonents = Abonent::where('user_id', Auth::id())->get();
        if($abonents->count() == 0) return abort(403);
        return view('personalarea.index', compact('abonents'));
    }
}
