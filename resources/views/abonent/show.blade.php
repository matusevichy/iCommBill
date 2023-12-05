@extends('layouts.app')

@section('title', __('Abonent info'))

@section('content')
    <div class="container">
        @include('notice.index_abon', $notices)
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general"
                        aria-selected="true">{{__('General')}}
                </button>
                <button class="nav-link" id="v-pills-org-tarifs-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-org-tarifs" type="button" role="tab" aria-controls="v-pills-org-tarifs"
                        aria-selected="false">{{__('Organization tarifs')}}
                </button>
                <button class="nav-link" id="v-pills-tarifs-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-tarifs" type="button" role="tab" aria-controls="v-pills-tarifs"
                        aria-selected="false">{{__('Current tarifs')}}
                </button>
                <button class="nav-link" id="v-pills-saldo-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-saldo" type="button" role="tab"
                        aria-controls="v-pills-saldo"
                        aria-selected="false">{{__('Saldo')}}
                </button>
                <button class="nav-link" id="v-pills-accruals-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-accruals" type="button" role="tab" aria-controls="v-pills-accruals"
                        aria-selected="false">{{__('Accruals')}}
                </button>
                <button class="nav-link" id="v-pills-payments-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-payments" type="button" role="tab" aria-controls="v-pills-payments"
                        aria-selected="false">{{__('Payments')}}
                </button>
                <button class="nav-link" id="v-pills-counters-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-counters" type="button" role="tab" aria-controls="v-pills-counters"
                        aria-selected="false">{{__('Counters')}}
                </button>
            </div>
            <div class="tab-content container" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                     aria-labelledby="v-pills-home-tab">
                    <div class="row">
                        <div class="col">
                            {{__('Account number')}}
                        </div>
                        <div class="col">
                            {{$abonent->account_number}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__('Location number')}}
                        </div>
                        <div class="col">
                            {{$abonent->location_number}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__('Street')}}
                        </div>
                        <div class="col">
                            {{$abonent->street}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__("Square")}},{{__('m')}}<sup>2</sup>
                        </div>
                        <div class="col">
                            {{$abonent->square}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__("Ownership")}}
                        </div>
                        <div class="col">
                            {{($abonent->ownership == true) ? __("Yes") : __("No")}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__("Cadastral number")}}
                        </div>
                        <div class="col">
                            {{$abonent->cadastral_number}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{__('Owner')}}
                        </div>
                        <div class="col">
                            {{$abonent->user->name}} {{$abonent->user->phone}}
                        </div>
                    </div>
                    <div class="row  justify-content-center">
                        <div class="col-4 text-center">
                            {{__('Arrears')}}
                        </div>
                    </div>
                    @foreach($accrual_types as $accrual_type)
                        @php($current_saldo = get_abonent_saldo_by_accrual_type($abonent->id, $accrual_type->id))
                        @if($current_saldo !== 0)
                            <div class="row">
                                <div class="col">
                                    {{__($accrual_type->name)}}  {{($accrual_type->by_counter == true)? "(".__("by counter").")":""}}
                                </div>
                                <div class="col">
                                    {{$current_saldo}}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="v-pills-org-tarifs" role="tabpanel" aria-labelledby="v-pills-org-tarifs-tab">
                    <table class="table table-striped table-responsive-md">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Accrual type')}}</th>
                            <th>{{__('Value')}}</th>
                            <th>{{__('Zone')}}</th>
                            <th>{{__('Date begin')}}</th>
                            <th>{{__('Date end')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($org_tarifs as $org_tarif)
                            <tr>
                                <td>{{__($org_tarif->accrualtype->name)}}</td>
                                <td>{{$org_tarif->value}}</td>
                                <td>{{$org_tarif->counterzonetype? __($org_tarif->counterzonetype->name) : ''}}</td>
                                <td>{{$org_tarif->date_begin}}</td>
                                <td>{{$org_tarif->date_end}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="v-pills-tarifs" role="tabpanel" aria-labelledby="v-pills-tarifs-tab">
                    @include('abonenttarif.index', $tarifs)
                </div>
                <div class="tab-pane fade" id="v-pills-saldo" role="tabpanel" aria-labelledby="v-pills-saldo-tab">
                    @include('saldo.index', $saldos)
                </div>
                <div class="tab-pane fade" id="v-pills-accruals" role="tabpanel" aria-labelledby="v-pills-accruals-tab">
                    @include('accrual.index', $accruals)
                </div>
                <div class="tab-pane fade" id="v-pills-payments" role="tabpanel" aria-labelledby="v-pills-payments-tab">
                    @include('payment.index', $payments)
                </div>
                <div class="tab-pane fade" id="v-pills-counters" role="tabpanel" aria-labelledby="v-pills-counters-tab">
                    @include('counter.index', $counters)
                </div>
            </div>
        </div>

    </div>

@endsection
