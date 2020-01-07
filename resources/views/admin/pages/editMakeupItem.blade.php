@extends('admin/layout/adminLayout')
@section('style')
    <style>
        .form-control
        {
            padding: 0px 12px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
            <h1>
            Modify The Packet 
            <small> </small>
            </h1>
    </section>
    <section class="content">
            <div class="box box-primary">
                    <div class="box-header with-border">
                      <h2 class="box-title"> Packet Information  </h2>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">  Packet Code</label>
                            <input type="text" class="form-control" name="code" value="{{$item->code}}" required >  
                            <label for="exampleInputEmail1">  Packet Source</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="source_id">
                              @foreach ($sources as $source)
                                <option value="{{$source->id}}">{{$source->name}}</option>
                              @endforeach  
                            </select> 
                            <label for="exampleInputEmail1">  Discount %</label>
                            <input type="number" step="0.01" min="1" max="100" class="form-control" value="{{$item->precentage}}" name="precentage" required > 
                            <label for="exampleInputEmail1">  Authority</label>
                            <input type="date"  class="form-control" name="expired" value="{{$item->expiration}}" required >     
                            <input type="hidden" name="makeup_id" value="{{$makeup_id}}"  >      
                            <input type="hidden" name="id" value="{{$item->id}}"  >            
                        </div>
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Edit</button>
                      </div>
                    </form>
                  </div>
    </section>        
    @section('script')
        <script>
        </script>
    @endsection
@endsection






