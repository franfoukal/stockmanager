@extends('layouts.master')

@section('content')

<{{$component}} :cur_cont="{{Auth::user()->contratista()->get()}}"></{{$component}}>

@endsection