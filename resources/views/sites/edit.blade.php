@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- EDIT SITE FORM -->
                <div class="card mb-4">
                    <div class="card-header">Edit Site</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('update_site', $site->id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Site Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $site->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staging_url" class="col-md-4 col-form-label text-md-right">{{ __('Staging URL') }}</label>

                                <div class="col-md-6">
                                    <input id="staging_url" type="text" class="form-control{{ $errors->has('staging_url') ? ' is-invalid' : '' }}" name="staging_url" value="{{ $site->staging_url }}" required autofocus>

                                    @if ($errors->has('staging_url'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('staging_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="production_url" class="col-md-4 col-form-label text-md-right">{{ __('Production URL') }}</label>

                                <div class="col-md-6">
                                    <input id="production_url" type="text" class="form-control{{ $errors->has('production_url') ? ' is-invalid' : '' }}" name="production_url" value="{{ $site->production_url }}" required autofocus>

                                    @if ($errors->has('production_url'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('production_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Edit Site') }}
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