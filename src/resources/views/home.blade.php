@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div class="container">
        <div class="row justify-content-center">
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
    @push('scripts')
        <script src="resources/js/metisMenu.min.js"></script>
        <script src="resources/js/jquery.slimscroll.min.js"></script>
    @endpush
@endsection
