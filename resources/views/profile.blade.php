@extends('layouts.app')

@section('contents')
    <h1 class="mb-0">Profile</h1>
    <hr>
    <form method="POST" action="{{ route('register.update') }}" enctype="multipart/form-data" id="profile_setup_frm" action="">
        @csrf
        <div class="row">
            <div class="col-md-12 border-right">
                <div class="p-3 py-5">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="first name"
                                value="{{ auth()->user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Email</label>
                            <input type="text" name="email" disabled class="form-control" value="{{ auth()->user()->email }}"
                                placeholder="Email">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label class="labels">Password</label>
                            <div class="input-group">
                                <input name="password" type="password"
                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="exampleInputPassword" placeholder="Password" value="{{ auth()->user()->password }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary show-password-btn" type="button"
                                        data-toggle="password" data-target="exampleInputPassword">Show</button>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>

                    <script>
                        document.querySelectorAll('.show-password-btn').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                var targetId = this.getAttribute('data-target');
                                var passwordInput = document.getElementById(targetId);
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    this.textContent = 'Hide';
                                } else {
                                    passwordInput.type = 'password';
                                    this.textContent = 'Show';
                                }
                            });
                        });
                    </script>

                    <div class="mt-5 text-center">
                        <button id="btn" class="btn btn-primary profile-button" type="submit">Save Profile</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection