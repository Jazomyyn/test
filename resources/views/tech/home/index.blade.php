@extends('tech.template.main')
@push('styles')

@endpush
@push('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endpush

@section('content')
<div id="root">
</div>
@endsection
