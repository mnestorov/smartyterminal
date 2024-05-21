@extends('admin::layouts.admin')

@if (config('terminal.enabled'))
    @section('custom-styles')
        <link href="{{ asset('vendor/smartystudio/smartyterminal/css/app.css') }}" rel="stylesheet">
    @endsection
@endif

@section('admin-content')
    <div class="admin-header">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">
                    <i class="bi bi-terminal me-2"></i>{{ __('Terminal') }}
                </h1>
                <p class="text-muted">
                    {{ __('Run artisan commands from the browser.') }}
                </p>
            </div>
            <div class="col-auto mt-0 mb-lg-0 mb-3">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            {!! Cms::backTo('dashboard') !!}
                        </div>
                    </div><!--//row-->
                </div><!--//page-utilities-->
            </div><!--//col-auto-->
        </div><!--//row-->
    </div>

    <div class="row g-3">
        <div class="col-12 mt-0">

            <hr class="my-4">

            <div class="row align-items-center justify-content-between">
                <div class="col-12">
                    @if (config('terminal.enabled'))
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="app-card app-card-settings shadow-sm p-3">
                                    <div class="app-card-body">
                                        <fieldset class="border-top border-bottom-0 border-left-0 border-right-0 border-3">
                                            <legend class="float-none w-auto p-2" style="padding-right: .9rem;"><i class="bi bi-three-dots"></i></legend>
                                            <div class="mb-3 row g-3 p-2">
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label form-label">{{ __('Terminal Shell') }}</label>
                                                    <div id="terminal-shell" style="height:700px;"></div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center text-warning fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{!! __('You need to install <b>smartystudio/smartyterminal</b> package and set APP_DEBUG to true.') !!}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@if (config('terminal.enabled'))
    @section('custom-scripts')
        <script src="{{ asset('vendor/smartystudio/smartyterminal/js/app.js') }}"></script>
        <script>
            (function() {
                new Terminal("#terminal-shell", {!! $options !!});
            })();
        </script>
    @endsection
@endif

