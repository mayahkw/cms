@extends('my_cms::html')

@section('content')
    @each('my_cms::part', $blocks, 'blocks')
@endsection
