<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) !!}

            @foreach ($setArea as $ka => $va)
                <div class="form-group row">

                    <label class="col-md-2 form-control-label">{{ $va['label'] }}<span
                            class="text-danger">*</span></label>
                    <div class="col-md-3">
                        {{ Form::text($ka, $subdistricts_name, [
                            'wire:ignore',
                            // 'wire:model' => $ka,
                            'class' => 'form-control auto-load',
                            'name' => $ka,
                        ]) }}
                        @error($ka)
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                </div>
            @endforeach


            <select class="select2" style="width: 100%;"></select>

            <div class="text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {



            $(".select2").select2({
                ajax: {
                    url: "{{route('test.get_request')}}",
                    dataType: 'json',
                    data: (params) => {
                        return {
                            q: params.term,
                            test: 'adsaddsf'
                        }
                    },
                    processResults: (data, params) => {
                        const results = data.map(item => {
                            return {
                                id: item.req_id,
                                text: item.req_year + ' ' + item.req_number,
                            };
                        });
                        return {
                            results: results,
                        }
                    },
                },
            });


            $('.auto-load').focus(function() {

                $(this).autocomplete({
                    source: '{{ config('app.svls_api') }}/area_api/' + $(this).attr('name') + '',
                    select: function(event, ui) {

                        if (ui.item.datas) {
                            // console.log(ui.item.datas);

                            @this.area_select = JSON.stringify(ui.item.datas);

                            for (x in ui.item.datas) {

                                //  @this.set(x, ui.item.datas[x]);

                                $('[name="' + x + '"]').val(ui.item.datas[x]);
                            }
                        }

                        return false;
                    },
                    minLength: 0,
                }).autocomplete("search");
            });
        });



        function setValue(name, val) {
            @this.set(name, val);
        }

        Livewire.on('emits', () => {
            $('.select2').select2();
        });

        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirect-to');
                    }
                });
        });

        function submit_click() {
            @this.submit();
        }
    </script>
@endpush
