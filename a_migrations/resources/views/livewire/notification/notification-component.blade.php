<div>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
            aria-expanded="false" data-animation="scale-up" role="button">
            <i class="icon wb-bell" aria-hidden="true"></i>
            <span class="badge badge-pill badge-danger up" style="font-size: 8px">{{ $noti_count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
            <div class="dropdown-menu-header">
                <h5>รายการแจ้งเตือน {{ $EmpRoleName }}</h5>
                <span class="badge badge-round badge-danger">{{ $noti_count_all }} รายการ</span>
            </div>
            <div class="list-group scrollable is-enabled scrollable-vertical">
                <div data-role="container" class="scrollable-container">
                    <div data-role="content" class="scrollable-content">
                        @foreach ($noti_list as $key => $value)
                            <div class="row">
                                <div class="list-group-item col-10" role="menuitem">
                                    <a href="javascript:void(0)" wire:click="awareNoti({{ $value->id }})">
                                        <div class="media">
                                            <div class="pl-10 pr-10">
                                                <i class="icon wb-order bg-red-600 white icon-circle"
                                                    aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">{{ $value->noti_name }}</h6>
                                                <time class="media-meta">{{ $value->noti_detail }}</time>
                                                <br>
                                                @if ($value->status == 0)
                                                    <small class="font-italic text-muted">ยังไม่อ่าน</small>
                                                @else
                                                    <small class="font-italic text-muted"><i class="icon wb-check-circle"></i>อ่านแล้ว
                                                        {{ formatDateThai($value->updated_at) }} น.</small>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-1 justify-content-center align-self-center">
                                    <a href="javascript:void(0)">
                                        <i class="icon wb-trash text-danger"
                                            onclick="deleteNoti({{ $value->id }})"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="dropdown-menu-footer">
                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                    <i class="icon wb-settings" aria-hidden="true"></i>
                </a>
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                    การแจ้งเตือนทั้งหมด
                </a>
            </div>
        </div>
    </li>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            Livewire.on('noti_emits', () => {
                swal('', 'ลบข้อมูลเรียบร้อยแล้ว', 'success');
            });
        });
        function deleteNoti(id) {
            swal({
                title: 'ยืนยันการลบ ข้อมูลแจ้งเตือน !',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.deleteNoti(id);
                } else {
                    console.log('reject delete');
                }
            });
        }
    </script>
@endpush
