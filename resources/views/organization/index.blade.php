@extends('layouts.app')

@section('title', __('Organizations'))

@section('content')
    <div class="container">
        @can('create', \App\Models\Organization::class)
            <a href="{{route('organizations.create')}}" class="btn btn-primary"
               role="button">{{__("Add")}} </a>
        @endcan
        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th scope="col">{{__("Organization name")}}</th>
                <th scope="col">{{__("Organization type")}}</th>
                <th scope="col">{{__("Location")}}</th>
                <th scope="col">{{__("Abonents count")}}</th>
                <th scope="col">{{__("Abonents limit")}}</th>
                <th scope="col">{{__("Accrual date")}}</th>
                <th scope="col">{{__("Owners")}}</th>
                <th scope="col">{{__("Active")}}</th>
                <th scope="col">{{__("Actions")}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($organizations as $org)
                <tr>
                    <th scope="row"><a href="{{route('organizations.show', $org->id)}}"> {{$org->name}}</a></th>
                    <td>{{__($org->organizationtype->name)}}</td>
                    <td>{{$org->location}}</td>
                    <td>{{$org->abonents->count()}}</td>
                    <td>{{$org->user_limit}}</td>
                    <td>{{$org->accrual_date}}</td>
                    <td>
                        @foreach($org->users as $user)
                            <span>{{$user->name}}</span>
                        @endforeach
                    </td>
                    <td>{{$org->is_active == 1? __('Active') : __('Not active')}}</td>
                    @can('update', $org)
                        <td><a href="{{route('organizations.edit', $org->id)}}" class="btn btn-primary"
                               role="button">{{__("Edit")}}</a>
                            {{--                        <form action="{{ route('organizations.destroy', $org->id) }}" method="POST">--}}
                            {{--                            @csrf--}}
                            {{--                            @method('DELETE')--}}
                            {{--                            <button class="btn btn-primary" onclick="return confirm('Are you sure?')">{{__('Delete')}}</button>--}}
                            {{--                        </form>--}}
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
