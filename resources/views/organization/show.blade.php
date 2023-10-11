@extends('layouts.app')

@section('title', __('Organization'))

@section('content')
    <div class="container">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general"
                        aria-selected="true">{{__('General')}}
                </button>
                <button class="nav-link" id="v-pills-notice_for_owners-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-notice_for_owners" type="button" role="tab"
                        aria-controls="v-pills-notice_for_owners"
                        aria-selected="false">{{__('Notices for owner')}}
                </button>
                <button class="nav-link" id="v-pills-notices-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-notices" type="button" role="tab" aria-controls="v-pills-notices"
                        aria-selected="false">{{__('Notices')}}
                </button>
                <button class="nav-link" id="v-pills-tarifs-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-tarifs" type="button" role="tab" aria-controls="v-pills-tarifs"
                        aria-selected="false">{{__('Tarifs')}}
                </button>
                <button class="nav-link" id="v-pills-expences-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-expences" type="button" role="tab" aria-controls="v-pills-expences"
                        aria-selected="false">{{__('Expences')}}
                </button>
                <button class="nav-link" id="v-pills-incomes-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-incomes" type="button" role="tab" aria-controls="v-pills-incomes"
                        aria-selected="false">{{__('Incomes')}}
                </button>
                <button class="nav-link" id="v-pills-saldos-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-saldos" type="button" role="tab" aria-controls="v-pills-saldos"
                        aria-selected="false">{{__('Saldo')}}
                </button>
                <button class="nav-link" id="v-pills-abonents-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-abonents" type="button" role="tab" aria-controls="v-pills-abonents"
                        aria-selected="false">{{__('Abonents')}}
                </button>
            </div>
            <div class="tab-content container" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                     aria-labelledby="v-pills-home-tab">
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
                    <div class="row">
                        <div class="col">
                            {{__('Organization balance')}}
                        </div>
                        <div class="col">
                            {{get_organization_saldo($organization->id)}}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-notice_for_owners" role="tabpanel" aria-labelledby="v-pills-notice_for_owners-tab">
                    @include('noticeforowner.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-notices" role="tabpanel" aria-labelledby="v-pills-notices-tab">
                    @include('notice.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-tarifs" role="tabpanel" aria-labelledby="v-pills-tarifs-tab">
                    <a href="{{route('accruals.createByOrg', $organization->id)}}" class="btn btn-primary  mb-1"
                       role="button">{{__("Create accruals for abonents")}} </a>
                    @include('tarif.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-expences" role="tabpanel" aria-labelledby="v-pills-expences-tab">
                    @include('organizationexpence.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-incomes" role="tabpanel" aria-labelledby="v-pills-incomes-tab">
                    @include('organizationincome.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-saldos" role="tabpanel" aria-labelledby="v-pills-saldos-tab">
                    @include('organizationsaldo.index', $organization)
                </div>
                <div class="tab-pane fade" id="v-pills-abonents" role="tabpanel" aria-labelledby="v-pills-abonents-tab">
                    @include('abonent.index', [$organization, $abonents])
                </div>
            </div>
        </div>
    </div>
@endsection
