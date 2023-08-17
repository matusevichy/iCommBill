<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', [Notice::class, $organization])) return abort(403);
        return view('notice.create', compact('organization'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $organization = Organization::whereId($request->organization_id)->first();
        if ($user == null || $user->cannot('create', [Notice::class, $organization])) return abort(403);
        $validation = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'date_begin' => ['required', 'date'],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);

        $notice = new Notice();
        $notice->text = $request->text;
        $notice->date_begin = $request->date_begin;
        $notice->date_end = $request->date_end;
        $notice->organization_id = $request->organization_id;
        $notice->save();

        return redirect('organizations/' . $organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $notice)) return abort(403);
        return view('notice.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $notice)) return abort(403);
        $validation = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'date_begin' => ['required', 'date'],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
        ]);

        $notice->fill($request->only('text', 'date_begin', 'date_end'));
        $notice->save();
        return redirect('organizations/' . $notice->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $organization = Organization::whereId($notice->organization_id)->first();

        $notice->delete();
        return redirect('organizations/' . $organization->id);
    }
}
