<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;

class TutorDashboard extends Component
{
  use LivewireAlert;
  use WithFileUploads;
  public $modalOpen = false;
  public $students = [];
  public $categories = [];
  public $selectedStudentId = null;
  public $studentCategories = [];
  public $selectedCategories = [];
  public $selectedStudentToRemoveId = null;
  public $user;
  public $showRemoveStudentModal = false;
  public $videos = [];
  public $documents = [];
  public $videosCount = 0;
  public $documentsCount = 0;
  public $newVideoData = [
    'video_url' => '',
    'thumbnail' => null,
    'description' => '',
    'selectedCategories' => [],
    'source' => 'Uoutube',
  ];
  public $videoFile = null;

  public $newVideoSource = 'Youtube';
  public function mount()
  {

    $this->user = Auth::user();
    if ($this->user->role !== 'tutor') {
      return redirect()->to('/');
    }
    $this->students = $this->user->getStudents();
    $this->categories = $this->user->getOwnedCategories();
    $this->videos = $this->user->getVideos();
    $this->documents = $this->user->getDocuments();
    $this->videosCount = $this->user->getVideosCount();
    $this->documentsCount = $this->user->getDocumentsCount();
  }

  public function hydrate()
  {
    $this->user = Auth::user();
    $this->students = $this->user->getStudents();
    $this->categories = $this->user->getOwnedCategories();
  }

  public function removeStudent($studentId)
  {
    $this->user->removeStudentFromTutor($studentId);
    $this->students = $this->user->getStudents();

    $this->alert('success', 'Student removed successfully.');
  }

  public function selectStudentToRemove($studentId)
  {
    $this->selectedStudentToRemoveId = $studentId;
  }
  public function confirmRemoveStudent()
  {
    $this->removeStudent($this->selectedStudentToRemoveId);
    $this->selectedStudentToRemoveId = null;
  }
  public function cancelRemoveStudent()
  {
    $this->selectedStudentToRemoveId = null;
  }

  public function assignCategories()
  {
    User::assignCategoriesToStudent($this->selectedCategories, $this->selectedStudentId);
    $this->studentCategories = [];
    $this->selectedCategories = [];
    $this->selectedStudentId = null;
    $this->alert('success', 'Categories assigned successfully.');
  }

  public function getStudentCategories()
  {
    $this->studentCategories = User::getStudentCategories($this->selectedStudentId);
    $this->selectedCategories = [];
    foreach ($this->studentCategories as $category) {
      if (in_array($category->id, $this->categories->pluck('id')->toArray())) {
        $this->selectedCategories[] = $category->id;
      }
    }
  }

  public function selectStudent($studentId)
  {
    $this->selectedStudentId = $studentId;
    $this->getStudentCategories();
  }

  public function unselectStudent()
  {
    $this->selectedStudentId = null;
    $this->studentCategories = [];
    $this->selectedCategories = [];
  }
  public function updateSelectedCategories($categories)
  {
    $this->selectedCategories = $categories;
  }

  public function addVideo()
  {
    $this->validate([
      'newVideoData.video_url' => 'nullable|url',
      'newVideoData.video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:8192000',
      'newVideoData.thumbnail' => 'nullable|image|max:2048',
      'newVideoData.description' => 'required|string|max:255',
      'newVideoData.selectedCategories' => 'required|array',
      'newVideoData.source' => 'required|in:Youtube,File',
    ]);

    if ($this->newVideoData['source'] === 'File') {
      $this->newVideoData['video_url'] = null;
      $videoUri = $this->uploadFile($this->videoFile);
    } else {
      $this->newVideoData['video_file'] = null;
      $this->newVideoData['thumbnail'] = null;
    }
    return;
    $this->user->addVideo($this->newVideoData);
    $this->videos = $this->user->getVideos();
    $this->videosCount = $this->user->getVideosCount();
    $this->newVideoData = [
      'video_url' => '',
      'video_file' => null,
      'thumbnail' => null,
      'description' => '',
      'selectedCategories' => [],
      'source' => 'Youtube',
    ];
    $this->newVideoSource = null;
    $this->alert('success', 'Video added successfully.');
  }

  public function uploadFile($file)
  {
    // try to upload the file to bunny.net and return the URL, if it fails, upload to local storage and return the URL
    try {
      $output = shell_exec('ping -c 1 video.bunnycdn.com');
      $isOnline = str_contains($output, '1 received');
      if (!$isOnline) {
        throw new \Exception('Bunny CDN is not reachable');
      }
      $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'AccessKey' => env('BUNNY_VIDEO_API_KEY'),
      ])->post(env('BUNNY_VIDEO_API_BASE_URL') . "/library/" . env('BUNNY_VIDEO_LIBRARY_ID') . "/videos", [
        'title' => $file->getClientOriginalName(),
      ]);

      // print response body
      $responseBody = json_decode($response->body(), true);
      if ($response->failed()) {
        throw new \Exception('Failed to create video: ' . $responseBody['message']);
      }
      dd($responseBody);
    }
    catch (\Exception $e) {
      $filePath = $file->store('videos', 'local');
      return asset('storage/' . $filePath);
    }
  }
  public function render()
  {
    return view('livewire.tutor-dashboard');
  }
}
