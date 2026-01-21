<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class GalleryEdit extends Component
{   
    use WithFileUploads;

    public $gallery;
    public $existingImages = [];
    public $category;

    #[Validate('required')]
    public $title, $description;

    public $newImages = [];

    protected function rules()
    {
        return [
            'newImages.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    #[On('edit-gallery')]
    public function getGallery($id)
    {        
        $this->gallery = Gallery::find($id);
        $this->title = $this->gallery->title;
        $this->category = $this->gallery->category;
        $this->description = $this->gallery->description;
        $this->existingImages = $this->gallery->images ?? [];
        $this->newImages = [];
    }

    public function removeExistingImage($index)
    {
        $image = $this->existingImages[$index];
        
        // Delete from disk
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);

        // Update database immediately
        $this->gallery->update([
            'images' => $this->existingImages
        ]);

        $this->dispatch('refresh-gallery');
    }

    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
    }

    public function updateGallery()
    {
        $this->validate();

        $imagePath = $this->existingImages;

        if ($this->newImages) {
            foreach ($this->newImages as $image) {
                $imagePath[] = $image->store('galleries', 'public');
            }
        }

        $this->gallery->update([
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'images' => $imagePath,
        ]);

        $this->reset(['title', 'category', 'description', 'newImages', 'existingImages']);
        $this->dispatch('close-modal-gallery');
        $this->dispatch('refresh-gallery');
    }

    public function render()
    {
        return view('livewire.admin.gallery.gallery-edit');
    }
}
