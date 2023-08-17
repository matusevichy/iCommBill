@extends('layouts.app')

@section('title', __('Personal area'))

@section('content')
    <div class="container">
        <h3>{{__('Personal area')}}</h3>
        <div class="row">
            @foreach($abonents as $abonent)
                <div class="col-sm-6 pt-1">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        {{__('Account number')}}
                                    </div>
                                    <div class="col">
                                        {{$abonent->account_number}}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        {{__('Location number')}}
                                    </div>
                                    <div class="col">
                                        {{$abonent->location_number}}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        {{__('Organization name')}}
                                    </div>
                                    <div class="col">
                                        {{$abonent->organization->name}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="{{route('abonents.show', $abonent->id)}}" class="btn btn-primary"> {{__('View')}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
