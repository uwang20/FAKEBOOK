@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">{{ __('Edit Profile') }}</div>

                  <div class="card-body">
                      <form method="POST" action="{{ route('user.update',$user->id) }}">
                          @csrf
                          @method('PATCH')
                          {{-- FIRST NAME AND LAST NAME --}}
                          <div class="form-group row">
                              <label for="first-name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                              <div class="col-md-6">
                                  <input id="first-nam" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $user->first_name }}" required autofocus>

                                  @error('first_name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- -- --}}
                          <div class="form-group row">
                              <label for="last-name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                              <div class="col-md-6">
                                  <input id="last-name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $user->last_name  }}" required autofocus>

                                  @error('last_name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- NICKNAME --}}
                          <div class="form-group row">
                              <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nickname') }}</label>

                              <div class="col-md-6">
                                  <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') ?? $user->profile->nickname  }}"  autofocus>

                                  @error('nickname')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- END FIRST NAME AND LAST NAME --}}

                          {{-- BIO --}}
                          <div class="form-group row">
                              <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                              <div class="col-md-6">
                                  <textarea id="bio" type="text" rows="3" class="form-control @error('bio') is-invalid @enderror" name="bio" autofocus>{{ old('bio') ?? trim($user->profile->bio) }}</textarea>
                                  @error('bio')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- END BIO --}}

                          {{-- HOME AND CURRENT CITY --}}
                          <div class="form-group row">
                              <label for="home-city" class="col-md-4 col-form-label text-md-right">{{ __('Home City') }}</label>

                              <div class="col-md-6">
                                  <input id="home-city" type="text" class="form-control @error('home_city') is-invalid @enderror" name="home_city" value="{{ old('home_city') ?? $user->profile->home_city }}"  autofocus>

                                  @error('home_city')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- -- --}}
                          <div class="form-group row">
                              <label for="current-city" class="col-md-4 col-form-label text-md-right">{{ __('Current City') }}</label>

                              <div class="col-md-6">
                                  <input id="current-city" type="text" class="form-control @error('current_city') is-invalid @enderror" name="current_city" value="{{ old('current_city') ?? $user->profile->current_city }}"  autofocus>

                                  @error('current_city')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- END HOME AND CURRENT CITY --}}

                          {{-- WORK --}}
                          <div class="form-group row">
                              <label for="work" class="col-md-4 col-form-label text-md-right">{{ __('Work') }}</label>

                              <div class="col-md-6">
                                  <input id="work" type="text" class="form-control @error('work') is-invalid @enderror" name="work" value="{{ old('work') ?? $user->profile->work }}"  autofocus>

                                  @error('work')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>
                          {{-- END WORK --}}

                          {{-- RELATIONSHIP --}}
                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">{{ __('Relationship') }}</label>

                              <div class="col-md-6">
                                {{-- NONE --}}
                                <div class="form-check">
                                  <input id="none" type="radio" class="form-check-input @error('relationship') is-invalid @enderror" name="relationship" value="" @if($user->profile->relationship == '') checked @endif>
                                  <label for="none" class="form-check-label">None</label>
                                </div>
                                {{-- SINGLE --}}
                                <div class="form-check">
                                  <input id="single" type="radio" class="form-check-input @error('relationship') is-invalid @enderror" name="relationship" value="Single" @if($user->profile->relationship == 'Single') checked @endif>
                                  <label for="single" class="form-check-label">Single</label>
                                </div>
                                {{-- INA A RELATIONSHIP --}}
                                <div class="form-check">
                                  <input id="in-a-relationship" type="radio" class="form-check-input @error('relationship') is-invalid @enderror" name="relationship" value="In a relationship" @if($user->profile->relationship == 'In a relationship') checked @endif>
                                  <label for="in-a-relationship" class="form-check-label">In a Relationship</label>
                                </div>
                                {{-- MARRIED --}}
                                <div class="form-check">
                                  <input id="married" type="radio" class="form-check-input @error('relationship') is-invalid @enderror" name="relationship" value="Married" @if($user->profile->relationship == 'Married') checked @endif>
                                  <label for="married" class="form-check-label">Married</label>
                                </div>
                              </div>
                          </div>
                          {{-- END RELATIONSHIP --}}


                          <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      {{ __('Save') }}
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
