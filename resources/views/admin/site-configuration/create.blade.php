@extends('_layouts.admin._dashboard')

@section('content')
    <h1 class="display-4"><i class="fas fa-cogs"></i> Site Configuration</h1>
    <hr class="mb-5">

    @include('admin.inc._messages')


    <form action="/dashboard/site-configuration" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        <div id="tabs">
            <ul>
                <li>
                    <a href="#company-name">Company Name and Logo</a>
                </li>

                <li>
                    <a href="#company-details">Company Details</a>
                </li>
                <li>
                    <a href="#social-media">Social Media</a>
                </li>

                <li>
                    <a href="#analytics">SEO/Analytics</a>
                </li>

                <li>
                    <a href="#text-message">Text Messages</a>
                </li>
            </ul>

            <div id="company-name">
                <div class="col-12 py-4">
                    <div class="row mb-4">
                        <div class="col-md-4 bold">
                            <label for="company_name">Company Name: <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" id="company_name" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('company_name'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 bold mb-3">
                            <label for="filename" class="font-weight-bold">Company Logo: <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col">
                                    <input type="file" name="filename" class="form-control form-control-lg">
                                </div>
                            </div>


                            @if ($errors->has('filename'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('filename') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>



                </div>
            </div>

            <div id="company-details">
                <div class="col-12 py-4">
                    <div class="row">
                        <div class="col-md-4 bold">
                            <label for="phone">Phone: <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('phone'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </div>
                            @endif
                        </div>


                        <div class="col-md-4 bold">
                            <label for="email">Email: <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="" id="email" class="form-control form-control-lg" required>
                            @if ($errors->has('email'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="address">Address: <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('address'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="row my-3">

                        <div class="col-md-4 bold">
                            <label for="address_1">Address 1:</label>
                            <input type="text" name="address_1" id="address_1" value="" class="form-control form-control-lg">
                            @if ($errors->has('address_1'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('address_1') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="town">Town: <span class="text-danger">*</span></label>
                            <input type="text" name="town" id="town" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('town'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('town') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="county">County: <span class="text-danger">*</span></label>
                            <input type="text" name="county" id="county" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('county'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('county') }}</strong>
                                </div>
                            @endif
                        </div>


                    </div>

                    <div class="row mt-4">

                        <div class="col-md-4 bold">
                            <label for="post_code">Post Code: <span class="text-danger">*</span></label>
                            <input type="text" name="post_code" id="post_code" value="" class="form-control form-control-lg" required>
                            @if ($errors->has('post_code'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="map_location">Location Map: </label>
                            <textarea name="map_location" value="" id="map_location" rows="8" class="form-control form-control-lg"></textarea>
                            @if ($errors->has('map_location'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('map_location') }}</strong>
                                </div>
                            @endif
                        </div>


                    </div>

                </div>
            </div>

            <div id="social-media">
                <div class="col-12 py-4">
                    <div class="row px-3 mb-4">
                        <div class="alert-warning p-3 text-dark">
                            Paste your Social URLs accounts in to the according fields if you want them to display in the front of the website!
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 bold">
                            <label for="facebook_url"><i class='fab fa-facebook-square fs-130'></i> Facebook URL: </label>
                            <input type="text" name="facebook_url" id="facebook_url" value="" class="form-control form-control-lg">
                            @if ($errors->has('facebook_url'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('facebook_url') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="twitter_url"><i class='fab fa-twitter-square fs-130'></i> Twitter Url: </label>
                            <input type="text" name="twitter_url" id="twitter_url" value="" class="form-control form-control-lg">
                            @if ($errors->has('twitter_url'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('twitter_url') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4 bold">
                            <label for="youtube_url"><i class='fab fa-youtube fs-130'></i> YouTube URL: </label>
                            <input type="text" name="youtube_url" id="youtube_url" value="" class="form-control form-control-lg">
                            @if ($errors->has('youtube_url'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('youtube_url') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4 bold">
                            <label for="instagram_url"><i class='fab fa-instagram fs-130'></i> Instagram URL: </label>
                            <input type="text" name="instagram_url" id="instagram_url" value="" class="form-control form-control-lg">
                            @if ($errors->has('instagram_url'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('instagram_url') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>

            <div id="analytics">
                <div class="col-12 py-4">
                    <div class="row">
                        <div class="col-md-4 bold">
                            <label for="google_analytics">Google Analytics: </label>
                            <textarea name="google_analytics" value="" id="google_analytics" rows="8" class="form-control form-control-lg"></textarea>
                            @if ($errors->has('google_analytics'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('google_analytics') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div id="text-message">
                <div class="col-12 py-4">
                    <div class="row">
                        <div class="col-md-4 bold">
                            <label for="send_from_text">Send From: </label>
                            <input type="text" name="send_from_text" id="send_from_text" value="" class="form-control form-control-lg" required>

                            @if ($errors->has('send_from_text'))
                                <div class="text-danger" role="alert">
                                    <strong>{{ $errors->first('send_from_text') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="js-btn-holder">
            <button type="submit" name="button" class="btn btn-primary"><i class="fas fa-save"></i> Save Site Configuration </button>
        </div>

    </form>

@endsection




@section('scripts')

    <script>
        $( function() {
            $( "#tabs" ).tabs();
        });
    </script>

@endsection
