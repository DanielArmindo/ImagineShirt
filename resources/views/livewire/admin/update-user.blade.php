@extends('livewire.admin.template.main')

@section('operation_action')
    <form method="POST" action="{{route('admin.update', ['admin' =>$user])}}" enctype="multipart/form-data">
        @method('PUT')
@endsection

@section('operation')
    Update User
@endsection
