@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile-picture" class="col-md-4 col-form-label text-md-right"> {{__('Profile Picture') }} </label>
                            <div class="col-md-6">
                                <input type="file" name="profile picture" id="profilePictureUpload" onchange="renderImage(this);">
                            </div>
                        </div>

                        <!-- Profile picture upload and preview-->
                        <div class="form-group row" >
                            <div class="col-md-6 text-md-center offset-3" id="imagePreview">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type ="text/javascript">

            /**
             * Loads and displays the image from the given file
             * @param input image file to use as a profile picture
             */
            function renderImage(input)
            {
                var imagePreview = document.getElementById("imagePreview");

                if(input.files)
                {
                    var reader = new FileReader();

                    var fileName = input.files[0].name;

                    if(canRender(fileName))
                    {
                        imagePreview.innerHTML = '<img src="" class="img-fluid rounded"  id="profilePicture" height="200" width="200" style="image-orientation: from-image">';

                        reader.onload = function (e)
                        {
                            $('#profilePicture').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }

                    else
                    {
                       imagePreview.innerHTML = '<div class="alert alert-warning" role="alert"> The image does not have a valid file format</div>';

                    }
                }
            }

            /**
             *
             * @param fileName the name of the image file to upload
             * @returns true if the image has an acceptable extension and filename, false otherwise
             */
            function canRender(fileName)
            {

                var fileExtension;

                var lastPeriod = fileName.lastIndexOf('.');

                if(lastPeriod > 0)
                {
                    fileExtension = fileName.substring(lastPeriod + 1).toLowerCase();

                    switch(fileExtension)
                    {
                        case "bmp": return true;

                        case "gif": return true;

                        case "jpg": return true;

                        case "jpeg": return true;

                        case "jif": return true;

                        case "jfif": return true;

                        case "png": return true;

                        case "svg": return true;

                        case "tif": return true;

                        case "tiff": return true;

                        default: false;
                    }

                }

                return (false);
            }

        </script>
    </div>
</div>
@endsection
