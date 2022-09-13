<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons-->
    @if($app_info)
    <link rel="shortcut icon" href="{{ asset('images/info/'.$app_info->fav) }}">
    @endif

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Forget Your Password</title>

    <!-- vendor css -->
    <link href="{{ asset('backend/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    
    <!-- Custome CSS-->
    <link href="{{ asset('auth/css/custom.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="{{ asset('backend/css/loader.css') }}">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/brackets/bracket.css') }}">

    <style>
        .password-box {
            position: relative;
        }

        .password-box .hide-password {
            display: none;
        }

        .password-box .fas {
            position: absolute;
            top: 60%;
            right: 30px;
            z-index: 10;
            cursor: pointer;
            color: #000;
        }

    </style>
</head>

<body>

    <!-- End Page Loading -->
    <div class="loading">Loading&#8230;</div>

    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse">
                <span class="tx-normal">
                    @if( $app_info )
                        <img src="{{ asset('images/info/'.$app_info->logo) }}" style="width: 100%;" alt="" class="responsive-img valign profile-image-login">
                    @endif
                </span>
            </div>

            @if( session()->has('success') )
            <div class="new badge green">
                {{ session()->get('success') }}
            </div>
            @endif

            @if( session()->has('failed') )
            <div class="new badge red">
                {{ session()->get('failed') }}
            </div>
            @endif

            <form class="login-form ajax-form mt-5" action="{{ route('post.email') }}" method="post">
                @csrf

                <div class="row">
                    <div class="input-field col s12 center">
                        
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Email Address</label>
                        <input id="email" type="text" name="email" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-info btn-block">Send Reset Password Link</button>
                    </div>
                </div>
            
            </form>

           

            <div class="mg-t-40 tx-center"><a href="{{ route('login.show') }}" class="tx-info">Login Here</a></div>
        </div>
    </div>

    
    <script src="{{ asset('backend/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/ajax_form_submit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/custom-script.js') }}"></script>  
    

    <script>
        $(".show-password").click(function() {
            let $this = $(this)
            $this.closest(".password-box").find("#password-field").attr("type", "text")
            $this.closest(".password-box").find(".show-password").hide()
            $this.closest(".password-box").find(".hide-password").show()
        })

        $(".hide-password").click(function() {
            let $this = $(this)
            $this.closest(".password-box").find("#password-field").attr("type", "password")
            $this.closest(".password-box").find(".show-password").show()
            $this.closest(".password-box").find(".hide-password").hide()
        })
    </script>

</body>

</html>
