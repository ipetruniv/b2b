@extends('layouts.main')
@section('content')
    <div>
        Test lang work!
        <h2>{{ App::getLocale() }}</h2>
    </div>
@endsection
@section('js-files')
    @parent
@endsection