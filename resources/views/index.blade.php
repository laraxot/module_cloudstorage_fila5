<?php

declare(strict_types=1);
?>
@extends('cloudstorage::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('cloudstorage.name') !!}</p>
@endsection
