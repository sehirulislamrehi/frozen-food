<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


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

    <title>Frozen Food Software</title>

    @include("backend.includes.css")

    <style>
         .custom-alert{
            position: fixed;
            left: 50%;
            top: 1%;
            width: 30%;
            transform: translateX(-50%);
            min-height: max-content;
            z-index: 99999;
            background: white;
            border-radius: 5px;
            border: 1px solid #d1d1d1;
            box-shadow: black 1px 1px 4px -1px;
            padding: 25px 15px;
        }
        .custom-alert .logo img{
            width: 60%;
            display: block;
            margin: 0 auto;
        }
        .custom-alert p{
            text-align: center;
            margin-top: 15px;
        }
        .custom-alert h3{
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 15px;
        }
    </style>


</head>

<body>

    @if( session()->has('success') || session()->has('warning') || session()->has('error') )
    <div class="alert alert-dismissible fade show custom-alert" role="alert">
        <div class="logo">
            <img src="{{ asset('images/info/'. $app_info->logo) }}" class="img-fluid" alt="logo">
        </div>
        <hr>
        @if( session()->get('success') )
            <h3>Success</h3>
            <p>{{ session()->get('success') }}</p>
        @elseif(  session()->get('warning') )
            <h3>Warning</h3>
            <p>{{ session()->get('warning') }}</p>
        @elseif(  session()->get('error') )
            <h3>Error</h3>
            <p>{{ session()->get('error') }}</p>
        @endif

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <!-- MY MODAL -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- MY MODAL END -->

    <!-- MY MODAL large -->
    <div class="modal fade bd-example-modal-lg" id="largeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- MY MODAL large END -->

    <!-- ########## START: LEFT PANEL ########## -->
    @include("backend.includes.left_panel")
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    @include("backend.includes.head_panel")
    <!-- ########## END: HEAD PANEL ########## -->


    <!-- ########## START: MAIN PANEL ########## -->
    <div class="loading">Loading&#8230;</div>
    @yield('body-content')
    <!-- ########## END: MAIN PANEL ########## -->

    @include("backend.includes.script")
    
</body>

</html>