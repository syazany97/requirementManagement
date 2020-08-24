@extends('layouts.app')
@section('content')
<project-index :show-project="{{route('projects.show')}}"></project-index>
@endsection



