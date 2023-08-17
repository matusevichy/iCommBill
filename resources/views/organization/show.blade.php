@extends('layouts.app')

@section('title', __('Organization'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                {{__(('Organization name'))}}
            </div>
            <div class="col">
                {{$organization->name}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__(('Location'))}}
            </div>
            <div class="col">
                {{$organization->location}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__(('Abonents limit'))}}
            </div>
            <div class="col">
                {{$organization->user_limit}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__(('Accrual date'))}}
            </div>
            <div class="col">
                {{$organization->accrual_date}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Owners')}}
            </div>
            <div class="col">
                @foreach($organization->users as $user)
                    {{$user->name}}
                @endforeach
            </div>
        </div>
        <div class="accordion" id="accordion_organization">
            <div class="accordion-item">
                <h2 class="accordion-header" id="notices_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#notices" aria-expanded="false" aria-controls="notices">
                        {{__('Notices')}}
                    </button>
                </h2>
                <div id="notices" class="accordion-collapse collapse" aria-labelledby="notices_header"
                     data-bs-parent="#accordion_organization">
                    <div class="accordion-body">
                        @include('notice.index', $organization)
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="tarifs_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#tarifs" aria-expanded="false" aria-controls="tarifs">
                        {{__('Tarifs')}}
                    </button>
                </h2>
                <div id="tarifs" class="accordion-collapse collapse" aria-labelledby="tarifs_header"
                     data-bs-parent="#accordion_organization">
                    <div class="accordion-body">
                        <a href="{{route('accruals.createByOrg', $organization->id)}}" class="btn btn-primary  mb-1"
                           role="button">{{__("Create accruals for abonents")}} </a>
                        @include('tarif.index', $organization)
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="abonents_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#abonents" aria-expanded="false" aria-controls="abonents">
                        {{__('Abonents')}}
                    </button>
                </h2>
                <div id="abonents" class="accordion-collapse collapse" aria-labelledby="abonents_header"
                     data-bs-parent="#accordion_organization">
                    <div class="accordion-body">
                        @include('abonent.index', [$organization, $abonents])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
