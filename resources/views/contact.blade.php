@extends('layouts.app')

@section('content')
    <h1>CONTACT US</h1>
   {{ Form::open(['url' => 'contact/submit']) }}
        <div class="form-group">
            {{Form::label('name','Name')}}
            {{Form::text('name','',['placeholder'=> 'Enter Name','class'=>'form-control'])}}
        </div> 
        <div class="form-group">
            {{Form::label('email','E-mail Address')}}
            {{Form::text('email','',['placeholder'=> 'Enter E-mail Address','class'=>'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('message','Message')}}
            {{Form::textarea('message','',['placeholder'=> 'Message','class'=>'form-control'])}}
        </div> 
        <div>
            {{Form::submit('SUBMIT',['class'=>'btn btn-primary'])}}
        </div>
    {{ Form::close() }}
@endsection