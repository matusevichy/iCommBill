<div>
{{--    <h3>{{__('Accruals')}}</h3>--}}
    @can('create', [\App\Models\Accrual::class, $abonent])
        <a href="{{route('accruals.create', $abonent->id)}}" class="btn btn-primary"
           role="button">{{__("Add")}} </a>
    @endcan
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th scope="row">{{__('Accrual type')}}</th>
            <th>{{__('Value')}}</th>
            <th>{{__('On date')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($accruals as $accrual)
            <tr>
                <td>{{__($accrual->accrualtype->name)}}</td>
                <td>{{$accrual->value}}</td>
                <td>{{$accrual->date}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $accrual)
                                <a href="{{route('accruals.edit', $accrual->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endcan
                        </div>
                        <div class="col col-sm-auto px-1">
                            @can('delete', $accrual)
                                <form action="{{ route('accruals.destroy', $accrual->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary"
                                            onclick="return confirm('Are you sure?')"><i
                                            title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i></button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
