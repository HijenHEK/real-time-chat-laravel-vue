@extends('layouts.app')

@section('content')



<div class="container">
    <div class="col-8 container mx-auto">
        @if(Session::has('message'))
        <div class="alert alert-success">
            {{Session::get('message')}}
        </div>
        @endif
    <form class="form" action="{{ Request('pass') ? '/profile?pass=true' : '/profile'}}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group d-flex justify-content-center">
                    
                    <div class="file-upload ">
                        <img src="{{Auth::user()->avatar}}" id="av" class="mx-auto avatar">
                        <div class="upload-text">Change avatar ?</div>
                    <input id="av-input" name="avatar" type="file" value="{{old('avatar') ?? Auth::user()->avatar}}" class="file-input @error('avatar') is-invalid @enderror">
                    </div>
                </div> 
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') ?? Auth::user()->name}}" placeholder="Enter your name">
                @error('name')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="uname">Uname</label>
                <input name="uname" type="text" class="form-control @error('uname') is-invalid @enderror" value="{{ old('uname') ?? Auth::user()->uname}}"  placeholder="User name">
                @error('uname')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') ?? Auth::user()->email}}" placeholder="foulen@fou.com">
                @error('email')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                @if(Request('pass'))
                <label for="name">Old Password</label>

                @else
                <label for="name">Password</label>

                @endif
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"   placeholder="Enter your Password">
                @error('password')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror  
                
                
            </div>

            @if(Request('pass'))
            <div class="form-group">
                <label for="name">New Confirmation</label>
                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror"   placeholder="Confirm your Password">
                @error('new_password')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror   
            </div>
            <div class="form-group">
                <label for="name">New Password Confirmation</label>
                <input name="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"   placeholder="Confirm your Password">
                @error('new_password_confirmation')
                <span class="text-danger text-small">{{$message}}</span>
                @enderror   
            </div>
            @else 
                <div class="form-group">

                    <a href="?pass=true">update password ?</a>
                </div>
            @endif

            <div class="form-group">
                

                <button type="submit" class="btn btn-success"> Update </button>
            </div>
        </form>
    </div>
</div>





@endsection
