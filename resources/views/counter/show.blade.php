@extends('layouts.app')

@section('title', __('Counter'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                {{__('Counter number')}}
            </div>
            <div class="col">
                {{$counter->number}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Date begin')}}
            </div>
            <div class="col">
                {{$counter->date_begin}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Date end')}}
            </div>
            <div class="col">
                {{$counter->date_end}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Accrual type')}}
            </div>
            <div class="col">
                {{__($counter->accrualtype->name)}}
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{__('Zones count')}}
            </div>
            <div class="col">
                {{__($counter->count_zones)}}
            </div>
        </div>
        @include('countervalue.index', $counter_values)
    </div>
@endsection
