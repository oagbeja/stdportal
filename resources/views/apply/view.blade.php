@extends('layouts.app')
@section('content')

<div class="container mt-3 pt-5">
    <div class="pt-4">
        <em><a href="/" class=" text-info">Home</a> > <a href="/apply" class=" text-info">Apply</a> > View</em>
    </div>
    <div id="myprint">
    <div class="card">
        
        <div class="card-header font-weight-bold">
            BIO DATA
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 offset-1">

                    <div class=" row ">
                        <div class="col-6 pl-0 " style="float:left"><label  class="col-form-label font-weight-bold">Title</label> </div>
                        <div class="col-6 pl-0 col-form-label" style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->title !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Surname</label> </div>
                        <div class="col-6 pl-0" style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->sname !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">First Name</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->fname !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Middle Name</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->mname !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Faculty</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $faculty->faculty_desc !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Programme</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $progcat->prog_desc !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">E-mail</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->email !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Contact Address</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->caddress !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Phone Number</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->phonenum !!}</div>
                    </div>

                </div>
                <div class="col-4 offset-1">

                    
                        <div class=" row " >
                            <div align="right">
                                <img src="{!! $imagePath !!}"  alt="No Image"  style="max-height:150px"  class=" rounded  img-thumbnail  w-50">
                            </div>
                        </div>

                   
                   
                    
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">NOK Phone Number</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->nokphonenum !!}</div>
                    </div>
                    <div class=" row ">
                        <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">NOK Contact Address</label> </div>
                        <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->nokcaddress !!}</div>
                    </div>


                </div>

            </div>
        </div>
        

    </div>
    <div class="card" >
        <div class="card-header font-weight-bold" >
            QUALIFICATIONS
        </div>
        <div class="card-body" >
            <h5>O Level </h5>
            <div class="row pt-2  pb-2 ">
                <div class="card col-6 pt-2 pb-1 ">
                    <p class="lead text-info">1<sup>st</sup> Sitting</p>
                    <div class="row pb-2">
                    <div class= "col-10 ">
                        <div class="d-flex">
                            <label for="exam1" class="col-6 ">Exam Name</label>
                            {{ $olevel->exam1}}
                        </div>
                        <div class="d-flex">
                            <label for="examyr1" class="col-6 ">Exam Year</label>
                            {{ $olevel->examyr1 }}
                        </div>
                        <div class="d-flex">
                            <label for="candnum1" class="col-6 ">Candidate No.</label>
                            {{  $olevel->candnum1 }}
                        </div>
                    
                    </div>
                    
                    </div>
                    <hr>
                    @for($i=0; $i<9; $i++)
                        @if(empty($olevel->subj1[$i])) @break; @endif
                        <div class=" row ">
                            <div class="col-6 pl-5" style="float:left"><label  class=" font-weight-bold">{!! $olevel->subj1[$i] !!}</label> </div>
                            <div class="col-6 pl-5 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $olevel->grad1[$i] !!}</div>
                        </div>
                        
                    @endfor
                </div>
                <div class="card col-6 pt-2 pb-1 ">
                    <p class="lead text-info">2<sup>nd</sup> Sitting</p>
                    <div class="row pb-2">
                    <div class= "col-10 ">
                        <div class="d-flex">
                            <label for="exam2" class="col-6 ">Exam Name</label>
                            {{ $olevel->exam2 ?? ''}}
                        </div>
                        <div class="d-flex">
                            <label for="examyr2" class="col-6 ">Exam Year</label>
                            {{ $olevel->examyr2 ?? '' }}
                        </div>
                        <div class="d-flex">
                            <label for="candnum2" class="col-6 ">Candidate No.</label>
                            {{  $olevel->candnum2 ?? '' }}
                        </div>
                    
                    </div>
                    
                    </div>
                    <hr>
                    @for($i=0; $i<9; $i++)
                        @if(empty($olevel->subj2[$i])) @break; @endif
                        <div class=" row ">
                            <div class="col-6 pl-5" style="float:left"><label  class=" font-weight-bold">{!! $olevel->subj2[$i] !!}</label> </div>
                            <div class="col-6 pl-5 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $olevel->grad2[$i] !!}</div>
                        </div>
                        
                    @endfor
                </div>
            </div>
            <h5>Degrees </h5>
            <div class="card pt-2 ">
                {{$data->other_qual}}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            OTHERS
        </div>
        <div class="card-body">
            <h4>Other Information </h4>
            <div class="offset-1">{{$data->comments}}</div>
        </div>
        <div class="card-footer">
            <button class="btn btn-warning btn-sm float-right pb-2" onclick="window.print()">Print</button>
        </div>
    </div>
    </div><!--end of myprint -->
    
</div>
@endsection