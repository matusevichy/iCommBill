@extends('layouts.app')

@section('title', __('Abonent info'))

@section('content')
    <div class="container">
        @include('notice.index_abon', $notices)
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

        <div class="accordion" id="accordion_abonent">
            <div class="accordion-item">
                <h2 class="accordion-header" id="tarifs_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#tarifs" aria-expanded="false" aria-controls="tarifs">
                        {{__('Current tarifs')}}
                    </button>
                </h2>
                <div id="tarifs" class="accordion-collapse collapse" aria-labelledby="tarifs_header"
                     data-bs-parent="#accordion_abonent">
                    <div class="accordion-body">
                        <table class="table table-striped table-responsive-md">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Accrual type')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Date begin')}}</th>
                                <th>{{__('Date end')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tarifs as $tarif)
                                <tr>
                                    <td>{{__($tarif->accrualtype->name)}}</td>
                                    <td>{{$tarif->value}}</td>
                                    <td>{{$tarif->date_begin}}</td>
                                    <td>{{$tarif->date_end}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="saldo_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#saldo" aria-expanded="false" aria-controls="saldo">
                        {{__('Saldo')}}
                    </button>
                </h2>
                <div id="saldo" class="accordion-collapse collapse" aria-labelledby="saldo_header"
                     data-bs-parent="#accordion_abonent">
                    <div class="accordion-body">
                        @include('saldo.index', $saldos)
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="accruals_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accruals" aria-expanded="false" aria-controls="accruals">
                        {{__('Accruals')}}
                    </button>
                </h2>
                <div id="accruals" class="accordion-collapse collapse" aria-labelledby="accruals_header"
                     data-bs-parent="#accordion_abonent">
                    <div class="accordion-body">
                        @include('accrual.index', $accruals)
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="payments_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#payments" aria-expanded="false" aria-controls="payments">
                        {{__('Payments')}}
                    </button>
                </h2>
                <div id="payments" class="accordion-collapse collapse" aria-labelledby="payments_header"
                     data-bs-parent="#accordion_abonent">
                    <div class="accordion-body">
                        @include('payment.index', $payments)
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="counters_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#counters" aria-expanded="false" aria-controls="counters">
                        {{__('Counters')}}
                    </button>
                </h2>
                <div id="counters" class="accordion-collapse collapse" aria-labelledby="counters_header"
                     data-bs-parent="#accordion_abonent">
                    <div class="accordion-body">
                        @include('counter.index', $counters)
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
