@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ciao <strong>{{ Auth::user()->name }}</strong>! Here is your profile: </div>

                <div class="card-body">
                    <p>
                        Email: {{ Auth::user()->email }}
                    </p>
                    <p>
                        Address: {{ Auth::user()->userDetail->address }}
                    </p>
                    <p>
                        Office number: {{ Auth::user()->userDetail->office_number }}
                    </p>
                    <p>
                        Date of birth: {{ Auth::user()->userDetail->birth_date }}
                    </p>
                    <p>
                        Signature: {{ Auth::user()->userDetail->signature }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
