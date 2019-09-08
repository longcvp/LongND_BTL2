@extends('_layout.layout')
@section('title')
Quản lý ví cá nhân
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
            <h2>Quản lý ví cá nhân của {{ Auth::user()->name }}</h2>
            <hr>
            <a href="{{ route('wallets.create') }}" type="button" class="btn btn-primary">Tạo ví mới</a>
            <hr>
            @if(count($wallets) != 0)
            <a href="{{ route('wallets.transfer', IN) }}" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-share-alt"></span> Chuyển tiền nội bộ</a>
            <a href="{{ route('wallets.transfer', OUT ) }}" type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-share-alt"></span>Chuyển tiền ra ngoài</a>
            <hr>
            @endif
            <div class="row">
                @if(count($wallets) != 0)
                <table id="table1" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên ví </th>
                            <th>SSID</th>
                            <th>Số tiền</th>              
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $key => $wallet)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $wallet->name }}</td>
                                <td>{{ $wallet->ssid }}</td>
                                <td>{{ number_format($wallet->money). ' vnđ' }}</td>
                                <td><a href="{{ route('wallets.edit', $wallet->id) }}"><span class="fa fa-edit"></span> Sửa</a></td>
                                <td><form action="{{ route('wallets.destroy', $wallet->id )}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type='submit' onclick="confirm_delete();" class="btn btn-danger" value="Xóa">
                                    </form>
                                </td>
                            </tr>  
                        @endforeach

                    </tbody>
                </table>    
                {{ $wallets->links() }}
                @else
                <p>Không có thông tin ví</p>
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
        if(!confirm("Bạn chắc chắn muốn xóa ví này"))
          event.preventDefault();            
    }

    
</script>
@endsection