@extends('layout/secretarylayout')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header" style="background-color: white">
                    <div class="d-flex justify-content-between">
                        <p>ตั้งค่า</p>

                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <p>การตั้งค่ารหัสผ่าน</p>
                    </div>
                    <form action="/updatepassword" id="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{-- @if ($error->any('old_password'))
                                <span class="text-danger">{{ $errors->first('old_password') }}</span>
                            @endif --}}
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control form-control-lg border-left-0" type="text"
                                value="{{ $username }}" disabled>
                        </div>
                        <div class= "form-group">
                            <label for="new_password" style="font-size:14px;">{{ 'New Password' }}</label>


                            <input id="new_password" type="password" class="form-control form-control-lg border-left-0"
                                name="new_password" required autocomplete="new-password"maxlength="6" minlength="6"
                                required
                                pattern = "(?=.*\d)(?=.* [a-z])(?=.* [A-Z])(?=.*?[0-9])(?=.*?[~`!@#$%\^&*()\-_=+[\]{};:\x27.,\x22\\|/?><]).{4,}">

                            {{-- @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror --}}

                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation" style="font-size:14px;">{{ 'Confirm Password' }}</label>


                            <input id="new_password_confirmation" type="password"
                                class="form-control form-control-lg border-left-0  @error('new_password') is-invalid @enderror"
                                name="new_password_confirmation" required autocomplete="new-password" maxlength="6"
                                minlength="6" required
                                pattern = "(?=.*\d)(?=.* [a-z])(?=.* [A-Z])(?=.*?[0-9])(?=.*?[~`!@#$%\^&*()\-_=+[\]{};:\x27.,\x22\\|/?><]).{4,}">
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        @if (session('success'))
                        <div class="text-success">Password updated successfully!</div>
                    @endif
                        <input value="update password" type="submit"
                            class="my-3 btn btn-primary"onclick="return confirm('คุณต้องการเปลี่ยนรหัสผ่านหรือไม่')" >
{{-- 
                        <button type="submit" class="my-3 btn btn-primary"
                            onclick="return confirm('คุณต้องการเปลี่ยนรหัสผ่านหรือไม่')">Update Password</button> --}}
                          

                        {{-- <input type="submit" class="my-3 btn btn-primary" value="Update Password"
                            {{ session('success') ? 'disabled' : '' }}>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif --}}
                </div>


                </form>



            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    </div>
@endsection
