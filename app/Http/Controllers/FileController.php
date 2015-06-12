<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use OParl\Model\File;

/**
 * FileController - Preview or download files.
 *
 * @package App\Http\Controllers
 **/
class FileController extends Controller
{
  /**
   * Get the file object from the database and load the corresponding blob
   *
   * @param Filesystem $fs
   * @param $id
   * @return array
   * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
   **/
  protected function getFile(Filesystem $fs, $id)
  {
    $file = File::findOrFail($id)->toArray();
    $file['data'] = $fs->get($file['file_name']);

    return $file;
  }

  /**
   * Return a file for live preview (does not work in Safari on OS X!)
   *
   * @param Filesystem $fs
   * @param $id
   * @return \Symfony\Component\HttpFoundation\Response
   **/
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

  /**
   * Return a file for download (Works regardless of the browser.)
   *
   * @param Filesystem $fs
   * @param $id
   * @return \Symfony\Component\HttpFoundation\Response
   **/
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