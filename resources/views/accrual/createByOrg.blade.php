@extends('layouts.app')

@section('title', __('Add accrual'))

@section('content')
    <div class="container">
        <form action="{{route('accruals.storeByOrg')}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                       value="{{ date('Y-m-d') }}" required autocomplete="value">
                <label for="value">{{__('Accruals date')}}</label>

                @error('date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <select name="accrualtype_id" id="accrualtype_id"
                        class="form-select  @error('accrualtype_id') is-invalid @enderror" required>
                    <option value="" selected>{{__('Select accrual type')}}</option>
                    @foreach($accrual_types as $type)
                        <option value="{{$type->id}}">{{__($type->name)}}
                            {{($type->by_counter == true)? "(".__("by counter").")":""}}
                        </option>
                    @endforeach
                </select>

                @error('accrualtype_id')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="by_square" name="by_square">
                <label class="form-check-label ps-1">{{__('Accruals by square')}}</label>
            </div>
            <div>
                <h3>{{__('Abonents')}}</h3>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="select_all">
                    <label class="form-check-label ps-1">{{__('Select all')}}</label>
                </div>
                @foreach($abonents as $abonent)
                    <div class="list-group">
                        <li class="list-group-item">
                            <input class="form-check-input abonent" type="checkbox" name="abonents[]" value="{{$abonent->id}}">
                            <label
                                class="form-check-label ps-1">N{{$abonent->location_number}} {{$abonent->user->name}}</label>
                        </li>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="organization_id" value="{{$organization->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        window.addEventListener("DOMContentLoaded", function () {
            const selectAll = document.getElementById("select_all");

            selectAll.addEventListener('change', function () {
                let abonents = document.querySelectorAll('.abonent');
                let checked = this.checked;
                for (let i = 0; i < abonents.length; i++) {
                    abonents[i].checked = checked;
                }
            });
        });
    </script>
@endsection
