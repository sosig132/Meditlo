<?php

namespace App\Livewire;

use App\Models\Content;
use App\Models\User;
use App\Rules\YouTubeUrl;
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
  public $videoToRemove = null;
  public $documentToRemove = null;
  public $selectedContent = null;
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
    'source' => 'youtube',
    'title' => '',
  ];

  public $newDocumentData = [
    'document_url' => null,
    'title' => '',
    'description' => '',
    'selectedCategories' => [],
  ];
  public $documentFile = null;
  public $videoFile = null;
  public $editedVideoData = [];
  public $editedDocumentData = [];
  public $selectedContentCategories = [];
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
    foreach ($this->videos as $video) {
      if ($video->source === 'youtube') {
        $queryParams = [];
        parse_str(parse_url($video->uri, PHP_URL_QUERY), $queryParams);
        $video->thumbnail = $queryParams['v'] ?? null;
        $video->thumbnail = 'https://img.youtube.com/vi/' . $video->thumbnail . '/hqdefault.jpg';
      }
    }
    $this->documents = $this->user->getDocuments();
    foreach ($this->documents as $document) {
      $document->file_type = $document->uri ? pathinfo($document->uri, PATHINFO_EXTENSION) : 'unknown';
      if ($document->file_type === 'pdf') {
        $document->icon = 'file-pdf';
      } elseif (in_array($document->file_type, ['doc', 'docx'])) {
        $document->icon = 'file-word';
      } else {
        $document->icon = 'file';
      }
    }
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
      'newVideoData.video_url' => 'nullable|string',
      'videoFile' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:8192000',
      'newVideoData.thumbnail' => 'nullable|image|max:2048',
      'newVideoData.description' => 'required|string|max:255',
      'newVideoData.selectedCategories' => 'required|array',
      'newVideoData.source' => 'required|in:youtube,File',
      'newVideoData.title' => 'required|string|max:255',
    ]);
    if ($this->newVideoData['source'] === 'File') {
      $this->newVideoData['video_url'] = null;
      $video = $this->uploadFile($this->videoFile);
      $this->newVideoData['video_url'] = $video['url'];
      $this->newVideoData['source'] = $video['source'];
    } else {

      $this->newVideoData['video_file'] = null;
      $this->newVideoData['thumbnail'] = null;
      $pattern = '%^(https?://)?(www\.)?'
            . '(youtube\.com/watch\?v=|youtu\.be/)'
            . '([a-zA-Z0-9_-]{11})(&.*)?$%';
      if ($this->newVideoData['source'] === 'youtube' && !preg_match($pattern, $this->newVideoData['video_url'])) {
        $this->alert('error', 'The video URL must be a valid YouTube URL.');
        return;
      }
    }

    if ($this->newVideoData['thumbnail']) {
      $this->newVideoData['thumbnail'] = $this->newVideoData['thumbnail']->store('thumbnails', 'public');
    }

    $this->newVideoData['user_id'] = $this->user->id;
    Content::addVideo($this->newVideoData);
    $this->videos = $this->user->getVideos();
    $this->videosCount = $this->user->getVideosCount();
    $this->newVideoData = [
      'video_url' => '',
      'thumbnail' => null,
      'description' => '',
      'selectedCategories' => [],
      'source' => 'youtube',
      'title' => '',
    ];
    $this->newVideoSource = null;
    $this->alert('success', 'Video added successfully.');
  }

  public function uploadFile($file)
  {
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

      $responseBody = json_decode($response->body(), true);
      if ($response->failed()) {
        throw new \Exception('Failed to create video: ' . $responseBody['message']);
      }
      $videoId = $responseBody['guid'];

      $uploadResponse = Http::withHeaders([
        'AccessKey' => env('BUNNY_VIDEO_API_KEY'),
        'Content-Type' => 'application/octet-stream',
      ])->withBody(
          file_get_contents($file->getRealPath()), // raw binary
          'application/octet-stream'
        )->put(
          env('BUNNY_VIDEO_API_BASE_URL') . "/library/" . env('BUNNY_VIDEO_LIBRARY_ID') . "/videos/" . $videoId . "?enabledResolutions=720p"
        );
      $responseBody = json_decode($response->body(), true);

      if ($uploadResponse->failed()) {
        throw new \Exception('Failed to upload video: ' . $responseBody['message']);
      }

      $this->alert('success', 'Video uploaded successfully. It will be available shortly, depending on the size of the video.');
      return ['url' => 'https://iframe.mediadelivery.net/play/' . env('BUNNY_VIDEO_LIBRARY_ID') . '/' . $videoId, 'source' => 'cloud'];
    } catch (\Exception $e) {
      $filePath = $file->store('videos', 'public');
      \Log::error('Video upload failed: ' . $e->getMessage());
      return ['url' => asset('storage/' . $filePath), 'source' => 'local'];
    }
  }

  public function cancelRemoveContent() {
    $this->selectedContent = null;
  }

  public function confirmRemoveContent()
  {
    if ($this->selectedContent) {
      $this->videoToRemove = Content::find($this->selectedContent);
      if ($this->videoToRemove) {
        $this->videoToRemove->delete();
        $this->videos = $this->user->getVideos();
        $this->videosCount = $this->user->getVideosCount();
        $this->alert('success', 'Content removed successfully.');
      }
    }

    $this->cancelRemoveContent();
  }

  public function selectContent($contentId)
  {
    $this->selectedContent = $contentId;
    $this->editedVideoData = [];
    $content = Content::find($contentId);
    if (!$content) {
      $this->alert('error', 'Content not found.');
      return;
    }
    if ($content->type == 'video') {
      $this->editedVideoData = [
        'title' => $content->title,
        'description' => $content->description,
      ];
    }

    if ($content->type == 'document') {
      $this->editedDocumentData = [
        'title' => $content->title,
        'description' => $content->description,
      ];
    }

  }

  public function unselectContent()
  {
    $this->selectedContent = null;
    $this->editedVideoData = [];
  }

  public function updateContent()
  {
    $this->validate([
      'editedVideoData.title' => 'required|string|max:255',
      'editedVideoData.description' => 'required|string|max:255',
    ]);
    $content = Content::find($this->selectedContent);
    if (!$content) {
      $this->alert('error', 'Content not found.');
      return;
    }
    $content->updateContent($this->editedVideoData);
    $this->videos = $this->user->getVideos();
    $this->videosCount = $this->user->getVideosCount();
    $this->alert('success', 'Content updated successfully.');
    $this->selectedContent = null;
    $this->editedVideoData = [];
  }

  public function selectContentCategories($contentId)
  {
    $content = Content::find($contentId);
    if (!$content) {
      $this->alert('error', 'Content not found.');
      return;
    }

    $this->selectedContent = $contentId;
    $this->selectedContentCategories = [];


    foreach ($content->categories as $category) {
      if (in_array($category->id, $this->categories->pluck('id')->toArray())) {
        $this->selectedContentCategories[] = $category->id;
      }
    }
  }

  public function assignContentCategories()
  {
    $content = Content::find($this->selectedContent);
    if (!$content) {
      $this->alert('error', 'Content not found.');
      return;
    }

    $content->addCategories($this->selectedContentCategories);
    $this->alert('success', 'Categories assigned to content successfully.');
    $this->selectedContent = null;
    $this->selectedContentCategories = [];
  }

  public function addDocument() {
    $this->validate([
      'documentFile' => 'required|file|mimes:pdf,doc,docx|max:163840',
      'newDocumentData.title' => 'required|string|max:255',
      'newDocumentData.description' => 'required|string|max:255',
      'newDocumentData.selectedCategories' => 'required|array',
    ]);
    $documentPath = $this->documentFile->store('documents', 'public');

    $this->newDocumentData['document_url'] = asset('storage/' . $documentPath);
    $this->newDocumentData['user_id'] = $this->user->id;
    $this->newDocumentData['source'] = 'local';
    $document = Content::addDocument($this->newDocumentData);
    $this->documents = $this->user->getDocuments();
    $this->documentsCount = $this->user->getDocumentsCount();
    $this->newDocumentData = [
      'document_url' => null,
      'title' => '',
      'description' => '',
      'selectedCategories' => [],
    ];
    $this->documentFile = null;
    $this->alert('success', 'Document added successfully.');
  }

  public function updateDocument()
  {
    $this->validate([
      'editedDocumentData.title' => 'required|string|max:255',
      'editedDocumentData.description' => 'required|string|max:255',
    ]);
    $content = Content::find($this->selectedContent);
    if (!$content) {
      $this->alert('error', 'Content not found.');
      return;
    }
    $content->updateContent($this->editedDocumentData);
    $this->documents = $this->user->getDocuments();
    $this->documentsCount = $this->user->getDocumentsCount();
    $this->alert('success', 'Content updated successfully.');
    $this->selectedContent = null;
    $this->editedDocumentData = [];
    $this->selectedContentCategories = [];
  }

  public function render()
  {
    return view('livewire.tutor-dashboard');
  }
}
