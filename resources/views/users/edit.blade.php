@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-primary" role="alert">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-item-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" widht="20" height="20">
                            <path
                                d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"
                                fill="#fff" />
                        </svg>
                        <h6 class="ml-2">Edit User</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="border-color:black">
            <div class="card border-0" >
                <div class="card-body">
                    <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                                </div>
                            </div>
                           
                            @foreach ($user->students as $item)
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <input type="text" class="form-control" id="kelas" name="kelas" value="{{$item->kelas}}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{$item->alamat}}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$item->phone}}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="roles">Akses</label>
                                    <select class="form-control" id="roles" name="roles">
                                        <option value="">Select roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}" {{$user->roles->contains($role->id) ? 'selected' : ''}}>{{$role->name}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" id="" class="form-control" value="/images/{{ $item->image }}">
                                    <img src="{{url('images/'.$item->image)}}" width="200px">
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="mt-3 mb-3 d-flex align-item-center">
                        <button type="submit" class="btn btn-outline-info">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20"
                                class="mr-2">
                                <path fill-rule="evenodd" fill="#1b4b72"
                                    d="M4.16 4.16l1.42 1.42A6.99 6.99 0 0 0 10 18a7 7 0 0 0 4.42-12.42l1.42-1.42a9 9 0 1 1-11.69 0zM9 0h2v8H9V0z" />
                            </svg>
                            Simpan data
                        </button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection