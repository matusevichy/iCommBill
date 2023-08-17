<div>
    {{--    <h3>{{__('Payments')}}</h3>--}}
    @can('create', [\App\Models\Payment::class, $abonent])
        <a href="{{route('payments.create', $abonent->id)}}" class="btn btn-primary"
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
        @foreach($payments as $payment)
            <tr>
                <td>{{__($payment->accrualtype->name)}}</td>
                <td>{{$payment->value}}</td>
                <td>{{$payment->date}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $payment)
                                <a href="{{route('payments.edit', $payment->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endif
                        </div>
                        <div class="col col-sm-auto px-1">
                            @can('delete', $payment)
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST">
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
