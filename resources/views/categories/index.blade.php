@extends('_layout.layout')
@section('title')
Quản lý danh mục chi tiêu cá nhân
@endsection
@section('content')
<div class="conten-wrapper">
    <section class="content container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
              <p>{{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
              <p>{{ session('error') }}</p>
        </div>
        @endif
    	<div class="container">
    		<h2>Quản lý danh mục chi tiêu của {{ Auth::user()->infomation->name }}</h2>
			<hr>
			<a href="{{ route('categories.create') }}" type="button" class="btn btn-primary">Tạo danh mục mới</a>
			<hr>
            <div class="row">
            	@if(count($categories) != 0)
                <table id="table1" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên danh mục </th>
                            <th>Danh mục cha</th>
                            <th>Danh mục thu/chi</th>             
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ ($category->parent_id == 0) ? 'Danh mục cấp 1' :  $category->nameParent->name}}</td>
                                <td>{{ ($category->type == THU) ? 'Danh mục thu' : 'Danh mục chi' }}</td>
                                <td><a href="{{ route('categories.edit', $category->id) }}"><span class="fa fa-edit"></span> Sửa</a></td>
                                <td><form action="{{ route('categories.destroy', $category->id )}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type='submit' onclick="confirm_delete();" class="btn btn-danger" value="Xóa">
                            </form>
                        </td>
                            </tr>  
                        @endforeach

                    </tbody>
                </table>    
                {{ $categories->links() }}
                @else
                <p>Không có thông tin danh mục</p>
                @endif
            </div>
    	</div>
    </section>
</div>
@endsection

@section('css')

@endsection

@section('js')
<script type="text/javascript">
    function confirm_delete()
    {
        if(!confirm("Bạn chắc chắn muốn xóa danh mục này"))
          event.preventDefault();            
    }

    
</script>
@endsection