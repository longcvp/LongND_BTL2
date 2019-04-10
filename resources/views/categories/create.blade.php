@extends('_layout.layout')
@section('title')
Tạo danh mục cá nhân
@endsection
@section('content')
	<div class="conten-wrapper">
		<section class="content container-fluid">
			<div class="container">
				<h2>Tạo danh mục cá nhân</h2>
				<form class="form-horizontal" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                    <div class="form-group">
                        <p style="text-align: center;"><span class="error">* required field</span></p>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Tên danh mục <span class="error">*</span></label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}" id="from_trans">
                        <label for="type" class="col-md-4 control-label">Chọn loại danh mục<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="type" id="type" required>
                                <option selected value="">Chọn loại danh mục</option>
                                <option value="3">Danh mục thu</option>
                                <option value="2">Danh mục chi</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}" id="root_category">
                        <label for="parent_id" class="col-md-4 control-label">Chọn danh mục cha<span class="error">*</span></label>

                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="parent_id" id="parent_id" required>
                            </select>
                            @if ($errors->has('parent_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('parent_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                                  
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Tạo danh mục
                            </button>
							<a href="{{ route("categories.index") }}" type="button" class="btn btn-info">Quay lại</a>
                        </div>

                    </div>
                 </form>
            </div>
		</section>	
	</div>
@endsection
@section('css')
<style type="text/css">
    h2 {
        text-align: center;
    }
    .error {
        color: red;
    }
</style>
@endsection
@section('js')
<script type="text/javascript">
   
    $(document).ready(function () {
        $("#root_category").hide();
        $("select[name='type']").on('change',function() {
            var type = $(this).val();  
            if(type != 0){
                $.ajax({
                    type:'POST',
                    headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url:'/categories/change/user',
                    data:{user_id: {{ Auth::id() }} ,type: type},
                    success:function(html){
                        $("#root_category").show();
                        $('#parent_id').html(html);
                    }
                }); 
            }else{
                $('#parent_id').html('<option value="">Chọn thể loại danh mục thu/chi trước </option>');
            }
        });

});
</script>
@endsection
