@extends('layouts.app')

@section('title', 'Maintenance - Oarkard')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #00D54B 0%, #00B140 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center text-white">
                <div class="mb-5">
                    <i class="fas fa-tools fa-5x mb-4" style="opacity: 0.8;"></i>
                    <h1 class="display-1 fw-bold mb-3">503</h1>
                    <h2 class="h3 mb-4">Maintenance Mode</h2>
                    <p class="lead mb-5" style="opacity: 0.9;">
                        We're currently performing scheduled maintenance.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                        <a href="javascript:location.reload()" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-redo me-2"></i>Try Again
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-home me-2"></i>Home Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
