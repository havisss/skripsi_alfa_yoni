@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="row">
    <!-- Profile Info Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-person-bounding-box me-2"></i> Profile Information
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Update your account's profile information and email address.</p>
                
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-shield-lock me-2"></i> Change Password
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>
                
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" required autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-key me-2"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        @if(session('status') === 'profile-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your profile information has been updated successfully.',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('status') === 'password-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your password has been changed successfully.',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush
