@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Role Manager</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Add Role</h3>
            </div>
            <div class="card-body">
                <form action="{{route('update.permission')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="user_id" value="{{$user_info->id}}" class="form-control">
                        <input type="text" readonly value="{{$user_info->name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Permisions</label>
                        <br>
                        @foreach ($all_permission as $permission)
                            <input type="checkbox" {{($user_info->hasPermissionTo($permission->name))?'checked':''}} value="{{$permission->id}}" name="permission[]"> {{$permission->name}}
                            <br>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Upate Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
