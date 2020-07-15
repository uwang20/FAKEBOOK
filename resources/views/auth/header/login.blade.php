<div>
    <header>
        <div class="header-inner-container">
            <div class="logo">
                <h1>SOME FB BACKEND CLONE</h1>
            </div>
            <div class="log-in-container">
        
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                
                    <div class="form-group">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                
                        <div class="input">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                            {{-- @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                
                        <div class="input">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                            {{-- @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>

                        @if (Route::has('password.request'))
                        <a class="forgot-pw" href="{{ route('password.request') }}">
                            {{ __('Forgot Account?') }}
                        </a>
                        @endif
                    </div>
                
                    <div class="form-group form-btn">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Log In') }}
                            </button>
                        </div>
                    </div>
                </form>
   
            </div>
        </div>
    </header>
</div>

