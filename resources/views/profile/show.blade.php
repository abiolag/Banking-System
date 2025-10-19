@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card account-card mb-4">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Full Name:</strong>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email Address:</strong>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Phone Number:</strong>
                            <p>{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Date of Birth:</strong>
                            <p>{{ $user->date_of_birth ? $user->date_of_birth->format('F d, Y') : 'Not provided' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Address:</strong>
                            <p>{{ $user->formatted_address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Account Information -->
            <div class="card account-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-wallet me-2"></i>Account Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Account Number:</strong><br>{{ $user->account_number }}</p>
                    <p><strong>Routing Number:</strong><br>{{ $user->routing_number ?? '021000021' }}</p>
                    <p><strong>Account Type:</strong><br>{{ ucfirst($user->account_type) }}</p>
                    <p><strong>Member Since:</strong><br>{{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>

            <!-- Security -->
            <div class="card account-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Security</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}#password" class="btn btn-outline-warning">
                            <i class="fas fa-key me-1"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection