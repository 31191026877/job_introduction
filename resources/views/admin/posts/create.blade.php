@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   <form class="form-horizontal">
                       <div class="form-group">
                           <lable>
                               Company
                           </lable>
                           <select name="company" id="company" class="form-control">
                               <option></option>
                           </select>
                       </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
@endsection

