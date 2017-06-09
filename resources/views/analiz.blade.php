@extends('layouts.main')

@section('content')
    <h2>WN8 аккаунта: {{ $WN8_all }}</h2>

    <table id="statistic" class="table table-bordered table-hover">

        <thead>
            <tr>
                <th rowspan="2"><p class="flex-center">Name</p></th>
                <th rowspan="2"><p class="flex-center">Бои</p></th>
                <th rowspan="2"><p class="flex-center">Урон</p></th>
                <th rowspan="2"><p class="flex-center">Фраги</p></th>
                <th rowspan="2"><p class="flex-center">Wn8</p></th>
                <th colspan="2"><p class="flex-center">Значения по серверу</p></th>
            </tr>
            <tr>
                <th><p class="flex-center">Средний урон</p></th>
                <th><p class="flex-center">Средние фраги</p></th>
            </tr>
        </thead>

        <tbody>

            @foreach($tanks as $tank)

                <tr>

                    <td>{{ $tank['name'] }}</td>
                    <td>{{ $tank['battles'] }}</td>
                    <td>{{ $tank['damage'] }}</td>
                    <td>{{ $tank['frags'] }}</td>
                    <td>{{ $tank['wn8'] }}</td>
                    <td>{{ $tank['exp_dam'] }}</td>
                    <td>{{ $tank['exp_frags'] }}</td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endsection

@section('includes_js')
    @parent
    <script src="{{ asset('/js/tinysort.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = document.getElementById('statistic')
                    ,tableHead = table.querySelector('thead')
                    ,tableHeaders = tableHead.querySelectorAll('th')
                    ,tableBody = table.querySelector('tbody')
                    ,index = 1
                    ;
            tableHead.addEventListener('click',function(e){
                var tableHeader = e.target
                        ,textContent = tableHeader.textContent
                        ,tableHeaderIndex,isAscending,order
                        ;
                if (textContent!=='exp') {
                    while (tableHeader.nodeName!=='TH') {
                        tableHeader = tableHeader.parentNode;
                    }
                    tableHeaderIndex = Array.prototype.indexOf.call(tableHeaders,tableHeader);
                    isAscending = tableHeader.getAttribute('data-order')==='asc';
                    order = isAscending?'desc':'asc';
                    tableHeader.setAttribute('data-order',order);
                    if(tableHeaderIndex >= 6) index = 0;
                    else index = 1;
                    tinysort(
                            tableBody.querySelectorAll('tr')
                            ,{
                                selector:'td:nth-child('+(tableHeaderIndex+index)+')'
                                ,order: order
                            }
                    );
                }
            });
        });
    </script>
@endsection