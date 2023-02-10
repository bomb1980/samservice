@extends('layouts.app',['activePage' => ''])

@section('content')

@endsection

@push('js')
<script type="text/javascript">
    $(function() {
            redirect_to_portal();
    });
    function redirect_to_portal(){
        swal({
            title: "ไม่มีสิทธิ์เข้าใช้งานระบบ",
            text: "คุณไม่มีสิทธิ์เข้าใช้งานระบบบริหารข้อมูลโครงการแก้ไขปัญหาความเดือดร้อนด้านอาชีพ ในกรณีที่ต้องการเข้าใช้งาน กรุณาติดต่อที่กลุ่มงานพัฒนายุทธศาสตร์",
            type: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "OK",
            },
            function(isConfirm){
                if (isConfirm) {
                    window.location = "https://e-office.mol.go.th/portal";
                }
            }
        );
    }
</script>
@endpush
