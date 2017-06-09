@extends('layouts.admin')

@section('content')

    <table class="table table-bordered">

        <tr>
            <th>Name</th>
            <th>Similar</th>
        </tr>
        @foreach($tanks_without_exp as $tank)
            <tr>
                <td>{{ $tank->name }}</td>

                {!! Form::open(['url' => route('change_similar'), 'class'=>'form-horizontal']) !!}
                {!! Form::hidden('tank_id', $tank->tank_id) !!}

                <td>
                    {!! Form::select('exp_tank_id', $tanks, $tank->exp_tank_id) !!}
                </td>

                <td>
                    {!! Form::button('Change', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
                </td>
                {!! Form::close() !!}
            </tr>
        @endforeach


    </table>

@endsection