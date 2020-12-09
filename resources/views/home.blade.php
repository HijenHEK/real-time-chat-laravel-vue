@extends('layouts.app')

@section('content')

<div id="app">
<whats-good :auth="{{Auth::id()}}" />
</div>

@endsection
