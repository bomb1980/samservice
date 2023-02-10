<div>
    {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!}
    <div class = "form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, 2565, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2 col-md-3', 'placeholder' => '--เลือกปีงบประมาณ--', 'disabled']) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">งวด</label>
        {!! Form::number('installment', 1, ['class' => 'form-control col-md-2']) !!}
        @error('installment')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class = "col-md-1"></div>

        <label class="form-control-label col-md-1 text-right pr-4">วันที่โอน</label>
        <div class="input-group col-md-2">
            <input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th"
                onchange="setDatePicker('stdate', event.target.value)" placeholder="วันที่โอน">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="icon wb-calendar" aria-hidden="true"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">เงินที่สามารถโอนได้</label>
        {!! Form::number('tran', 1, ['class' => 'form-control col-md-2']) !!}
        @error('tran')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-2 text-right pr-4">เงินที่โอนคืนส่วนกลาง</label>
        {!! Form::number('trancenback', 0.5, ['class' => 'form-control col-md-2']) !!}
        @error('trancenback')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">คงเหลือ</label>
        {!! Form::number('remain', 0.5, ['class' => 'form-control col-md-2']) !!}
        @error('remain')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </div>

    {!! Form::close() !!}
</div>

@push('js')
    {{-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"
        integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
        crossorigin=""></script>

    <!-- Load Esri Leaflet Geocoder from CDN -->
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
        integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
        crossorigin=""></script> --}}

    <script>
        $('.select2').select2();

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
            // if(name == 'stdate' || name = "endate"){
            //     @this.setArray();
            // }
        }

        function setValue(name, val) {
            @this.set(name, val);
        }

        $(".datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        Livewire.on('emits', () => {
            $('.select2').select2();
            $(".ads_Checkbox").change(function() {
                var searchIDs = $(".ads_Checkbox").map(function(_, el) {
                    if ($(this).is(':checked')) {
                        return 'on';
                    } else {
                        return 'off';
                    }
                }).get();
                // console.log(searchIDs);
            });

        });

        Livewire.on('popup', () => {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                }
            });
        });

        function button_function() {
            swal({
                title: 'ยืนยันการ ยกเลิกโครงการ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.redirect_to();
                }
            });
        }
        // var mymap = L.map('map').setView([13.731679, 100.561068], 17)

        // // add the OpenStreetMap tiles
        // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //         subdomains: ['a', 'b', 'c']
        //     })
        //     .addTo(mymap)

        // var gcs = L.esri.Geocoding.geocodeService();

        // mymap.on('click', (e) => {
        //     gcs.reverse().latlng(e.latlng).run((err, res) => {
        //         if (err) return;
        //         console.log(res.address);
        //         @this.set('moo', res.address.Block);
        //         @this.set('sub_district', res.address.City);
        //         @this.set('district', res.address.Subregion);
        //         @this.set('province', res.address.Region);
        //         @this.set('lat', res.latlng.lat);
        //         @this.set('lng', res.latlng.lng);
        //         L.marker(res.latlng).addTo(mymap).bindPopup(res.address.Match_addr).openPopup();
        //     });
        // });

        // function showPosition() {
        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition(function(position) {
        //             var positionInfo = "Your current position is (" + "Latitude: " + position.coords.latitude +
        //                 ", " + "Longitude: " + position.coords.longitude + ")";
        //             document.getElementById("result").innerHTML = positionInfo;
        //         });
        //     } else {
        //         alert("Sorry, your browser does not support HTML5 geolocation.");
        //     }
        // }
    </script>
@endpush
