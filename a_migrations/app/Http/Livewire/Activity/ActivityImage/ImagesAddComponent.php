<?php

namespace App\Http\Livewire\Activity\ActivityImage;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImagesAddComponent extends Component
{
    use WithFileUploads;

    public $files_image;

    public function render()
    {
        return view('livewire.activity.activity-image.images-add-component');
    }
}
