<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use OParl\Model\File;

class FileController extends Controller
{
  protected function getFile(Filesystem $fs, $id)
  {
    $file = File::findOrFail($id)->toArray();
    $file['data'] = $fs->get($file['file_name']);

    return $file;
  }

  public function access(Filesystem $fs, $id)
  {
    try
    {
      $file = $this->getFile($fs, $id);
    } catch(ModelNotFoundException $e)
    {
      return response('File not found.', 404, ['Content-type' => 'text/plain']);
    }

    return response($file['data'], 200, ['Content-type' => $file['mime_type']]);
  }

  public function download(Filesystem $fs, $id)
  {
    try
    {
      $file = $this->getFile($fs, $id);
    } catch(ModelNotFoundException $e)
    {
      return response('File not found.', 404, ['Content-type' => 'text/plain']);
    }

    return response($file['data'], 200, [
      'Content-type' => $file['mime_type'],
      'Content-disposition' => "attachment; filename={$file['sanitized_file_name']}"
    ]);
  }
}