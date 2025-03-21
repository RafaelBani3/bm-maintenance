@extends('layouts.Master')

@section('content')
    <div class="p-6 text-gray-900">
        {{ __("You're logged in!") }}
    </div>

    @can('view dashboard')
    YOU CAN VIEW DASHBOARDz
    @endcan

    @can('view cr')
    YOU CAN VIEW BA LIST 
    @endcan

    @can('view cr_ap' )
    YOU CAN VIEW CR Approval 
    @endcan
@endsection




