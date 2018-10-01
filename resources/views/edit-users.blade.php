@extends('template')

@section('favicon')
    {{asset('favicons/monicag.png')}}
@endsection

@section('title')
    MoniCAG | {{__('messages.titles.edit_users')}}
@endsection

@section('stylesheet')
    {{asset('user.css')}}
@endsection

@section('content')
    @header
        @slot('leftIcon')
            @include('icons/user')
        @endslot
        @slot('rightIcon')
            @include('icons/user')
        @endslot
        @slot('hasReturnButton')
            true
        @endslot
        @slot('hasCheckoutButton')
            false
        @endslot
        @slot('hasAuthBar')
            true
        @endslot
        @slot('title')
            {{__('messages.titles.edit_users')}}
        @endslot
    @endheader
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-borrowings-history">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="2" class="border-right">{{__('User')}}</th>
                            <th colspan="2">{{__('Actions')}}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col" class="border-right">{{__('E-mail address')}}</th>
                            <th scope="col">{{__('messages.edit_users.change_role')}}</th>
                            <th scope="col">{{__('Delete')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection