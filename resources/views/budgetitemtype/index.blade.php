@extends('layouts.app')

@section('title', __('Budget item types'))

@section('content')
    <div class="container">
        <h3>{{__('Budget item types')}}</h3>
        @can('create', \App\Models\BudgetItemType::class)
            <a href="{{route('budgetitemtypes.create')}}" class="btn btn-primary"
               role="button">{{__("Add")}} </a>
        @endcan
        <table class="table table-striped table-responsive-md">
            <thead>
            <tr>
                <th>{{__('Name')}}</th>
                <th>{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budgetitemtypes as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>
                        <div class="row">
                            <div class="col col-sm-auto px-1">
                                @can('update', $item)
                                    <a href="{{route('budgetitemtypes.edit', $item->id)}}" class="btn btn-primary"
                                       role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o"
                                                        aria-hidden="true"></i></a>
                                @endcan
                            </div>
{{--                            <div class="col col-sm-auto px-1">--}}
{{--                                @can('delete', $item)--}}
{{--                                    <form action="{{ route('budgetitemtypes.destroy', $item->id) }}" method="POST"--}}
{{--                                          class="form-inline">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button class="btn btn-primary" onclick="return confirm('Are you sure?')"><i--}}
{{--                                                title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                @endcan--}}
{{--                            </div>--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
