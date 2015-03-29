<?php namespace App\Http\Controllers;

use App\Commands\SerializeItemCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Response;
use Storage;

use OParl\File;

class FileController extends Controller
{
  protected function getFile($id)
  {
    $file = $this->dispatch(new SerializeItemCommand(File::findOrFail($id), app('request')));

    $file = $file['data'];
    $file['data'] = Storage::get('files/'.$file['fileName']);

    return $file;
  }

  public function access($id)
  {
    try
    {
      $file = $this->getFile($id);
    } catch(ModelNotFoundException $e)
    {
      return Response::make('File not found.', 404, ['Content-type' => 'text/plain']);
    }

    return Response::make($file['data'], 200, ['Content-type' => 'application/pdf']);
  }

  public function download($id)
  {
    try
    {
      $file = $this->getFile($id);
    } catch(ModelNotFoundException $e)
    {
      return Response::make('File not found.', 404, ['Content-type' => 'text/plain']);
    }

    return Response::make($file['data'], 200, [
      'Content-type' => $file['mimeType'],
      'Content-disposition' => "attachment; filename={$file['fileName']}"
    ]);
  }
}