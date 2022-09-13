
@if($app_info)
<link rel="shortcut icon" href="{{ asset('images/info/'.$app_info->fav) }}">
@endif

<!-- vendor css -->
<link href="{{ asset('backend/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- Bracket CSS -->
<link rel="stylesheet" href="{{ asset('backend/css/brackets/bracket.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/loader.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/css/custom.css') }}">

@yield("per_page_css")