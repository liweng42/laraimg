@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('public_path'))
                        <div class="alert alert-success" role="alert">
                            {{ session('public_path') }}
                        </div>
                    @endif

                    You are logged in! {{ $hello }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
