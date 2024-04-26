<!--end::Fonts-->

<!--begin::Page Vendors Styles(used by this page)-->
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />


<!--begin::Layout Themes(used by all pages)-->
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/themes/layout/header/menu/dark.css')}}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/themes/layout/brand/light.css')}}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
<!--end::Layout Themes-->

{{-- <link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/select/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/summernote/summernote.min.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/cropper/cropper.bundle.css') }}" rel="stylesheet" type="text/css" />
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/plugins/custom/pickadate/pickadate.css') }}" rel="stylesheet" type="text/css">


@yield('styles')
@include('lib.css')