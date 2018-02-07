@extends('layouts.default')
@section('title','主页')

@section('content')
  <div class="jumbotron">
    <h1>Hello BPEX</h1>
    <p class="lead">
      你现在所看到的是<a href="">bpex</a>的博客
    <p>
    <p>
      一切，从这里开始
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在开始注册</a>
    </p>
  </div>
@stop
