<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class GalleryCreate extends Component
{
    use WithFileUploads;

    public $category;

    #[Validate('required')]
    public $title, $description;

    #[Validate('required')]
    public $images = [];

    protected function rules()
    {
        return [
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function addImage()
    {
       $this->validate();

        $imagePath = [];
        foreach ($this->images as $image) {
            $imagePath[] = $image->store('galleries', 'public');
        }

        Gallery::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'category' => $this->category,
            'description' => $this->description,
            'images' => $imagePath,
        ]);

        $this->reset();
        $this->dispatch('close-modal-gallery');
        $this->dispatch('refresh-gallery');
    }

    public function render()
    {
        return view('livewire.admin.gallery.gallery-create');
    }
}
