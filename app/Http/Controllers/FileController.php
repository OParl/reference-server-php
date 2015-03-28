<?php namespace App\Http\Controllers;

use App\Commands\SerializeItemCommand;
use Response;
use Storage;

use OParl\File;

class FileController extends Controller
{
  protected function getFile($id)
  {
    $file = $this->dispatch(new SerializeItemCommand(File::find($id), app('request')));

    return [$file, Storage::get('files/'.$file['data']['fileName'])];
  }

  public function access($id)
  {
    $data = $this->getFile($id);

    abort('NYI');
  }

  public function download($id)
  {
    $data = $this->getFile($id);

    abort('NYI');
  }
}