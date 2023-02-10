<div>
    <link href="assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css">
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <div class="col-2 form-control-label"><h4><b>ก่อนดำเนินกิจกรรม :</b></h4></div>
            </div>
            <div class="form-group row">
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 form-control-label"><h4><b>ระหว่างดำเนินกิจกรรม :</b></h4></div>
            </div>
            <div class="form-group row">
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 form-control-label"><h4><b>หลังดำเนินกิจกรรม :</b></h4></div>
            </div>
            <div class="form-group row">
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2" wire:ignore>
                    {!! Form::file('files_image', ['data-height' => '250', 'wire:model' => 'files_image', 'class' => 'files_image']) !!}
                    @error('files_image')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <button wire:click="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('activity.activity_image.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:load', function() {
            $('.files_image').dropify();
        });

        function test() {
            var value = $('#brow_list').val();
            if (value) {
                window.livewire.emit('redirect-to-support', {
                    data: $('#brow [value="' + value + '"]').data('value')
                });
            } else {
                window.livewire.emit('redirect-to-support', {
                    data: 'false'
                });
            }
        }

        function checkname() {
            var value = $('#brow_list').val();
            if (value) {
                window.livewire.emit('redirect-to-name_search', {
                    data: $('#brow [value="' + value + '"]').data('value')
                });
            } else {
                window.livewire.emit('redirect-to-name_search', {
                    data: 'false'
                });
            }
        }
    </script>
@endpush
