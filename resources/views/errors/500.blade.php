@extends('layouts.app')

@section('title', 'Server Error - Oarkard')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #00D54B 0%, #00B140 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center text-white">
                <div class="mb-5">
                    <i class="fas fa-server fa-5x mb-4" style="opacity: 0.8;"></i>
                    <h1 class="display-1 fw-bold mb-3">500</h1>
                    <h2 class="h3 mb-4">Server Error</h2>
                    <p class="lead mb-5" style="opacity: 0.9;">
                        Something went wrong on our end. We're working to fix it.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ url('/') }}" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                        <a href="javascript:location.reload()" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-redo me-2"></i>Try Again
                        </a>
                    </div>
                </div>
                
                <div class="mt-5" style="opacity: 0.7;">
                    <p>Our technical team has been notified. Please try again in a few minutes.</p>
                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="text-white text-decoration-underline me-3">Home</a>
                        <a href="#" class="text-white text-decoration-underline me-3">Status</a>
                        <a href="#" class="text-white text-decoration-underline">Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection