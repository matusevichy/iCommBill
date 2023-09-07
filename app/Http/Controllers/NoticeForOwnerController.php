<?php

namespace App\Http\Controllers;

use App\Models\NoticeForOwner;
use App\Models\Organization;
use Illuminate\Http\Request;

class NoticeForOwnerController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoticeForOwner  $noticeforowner
     * @return \Illuminate\Http\Response
     */
    public function show(NoticeForOwner $noticeforowner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoticeForOwner  $noticeforowner
     * @return \Illuminate\Http\Response
     */
    public function edit(NoticeForOwner $noticeforowner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoticeForOwner  $noticeforowner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoticeForOwner $noticeforowner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoticeForOwner  $noticeforowner
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoticeForOwner $noticeforowner)
    {
        $organization = Organization::whereId($noticeforowner->organization_id)->first();
        $noticeforowner->delete();
        return redirect('organizations/' . $organization->id);
    }
}
