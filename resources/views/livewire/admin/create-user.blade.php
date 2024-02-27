@extends('livewire.admin.template.main')

@section('operation')
    Create User
@endsection

@section('operation_action')
    <form method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
@endsection

@section('password')

    <div class="form-group">
        <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
    </div>
    <div class="form-group">
        <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Confirm password" required>
    </div>

    @error('password')
        {{$message}}
    @enderror

@endsection
