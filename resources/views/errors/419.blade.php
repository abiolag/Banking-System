@extends('layouts.app')

@section('title', 'Session Expired - Oarkard')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #00D54B 0%, #00B140 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center text-white">
                <div class="mb-5">
                    <i class="fas fa-clock fa-5x mb-4" style="opacity: 0.8;"></i>
                    <h1 class="display-1 fw-bold mb-3">419</h1>
                    <h2 class="h3 mb-4">Session Expired</h2>
                    <p class="lead mb-5" style="opacity: 0.9;">
                        Your session has expired due to inactivity.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Again
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
