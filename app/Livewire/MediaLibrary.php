<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaLibrary extends Component
{
    use WithFileUploads;

    public $uploads = [];
    public $search = '';

    // AI Image Gen
    public $tab = 'upload'; // upload, library, ai
    public $aiImagePrompt = '';

    protected $listeners = ['refreshMedia' => '$refresh'];

    public function generateImage(\App\Services\AI\AIContentService $aiService)
    {
        $this->validate([
            'aiImagePrompt' => 'required|string|min:3|max:1000',
        ]);

        try {
            $url = $aiService->generateImage(Auth::user(), $this->aiImagePrompt);

            $this->dispatch('notify', message: 'Görsel başarıyla üretildi ve kütüphaneye eklendi! ', type: 'success');
            $this->aiImagePrompt = '';
            $this->tab = 'library'; // Switch to library to see result
            $this->dispatch('refreshMedia');

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Hata: ' . $e->getMessage(), type: 'error');
        }
    }

    public function updatedUploads()
    {
        $this->validate([
            'uploads.*' => 'image|max:10240', // 10MB Max per image
        ]);

        foreach ($this->uploads as $file) {
            $path = $file->store('media/' . Auth::id(), 'public');

            Media::create([
                'user_id' => Auth::id(),
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'disk' => 'public',
            ]);
        }

        $this->uploads = [];
        $this->dispatch('refreshMedia');
        session()->flash('success', 'Dosyalar başarıyla yüklendi.');
    }

    public function deleteMedia($id)
    {
        $media = Auth::user()->media()->findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        session()->flash('success', 'Dosya silindi.');
    }

    public function render()
    {
        $mediaItems = Auth::user()->media()
            ->when($this->search, fn($q) => $q->where('filename', 'like', '%' . $this->search . '%'))
            ->latest()
            ->get();

        return view('livewire.media-library', [
            'mediaItems' => $mediaItems
        ]);
    }
}
