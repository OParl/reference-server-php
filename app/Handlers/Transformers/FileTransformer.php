<?php namespace App\Handlers\Transformers;

use Oparl\File;

class FileTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['masterFile', 'derivativeFile'];

  protected function sanitizeFileName($filename)
  {
    if (strpos($filename, 'files/') === 0)
      $filename = substr($filename, 6);

    return $filename;
  }

  public function transform(File $file)
  {
    return [
      'id'           => route('api.v1.file.show', $file->id),
      'type'         => 'http://oparl.org/schema/1.0/File',
      'name'         => $file->name,
      'mimeType'     => ($file->mime_type) ?: 'application/octet-stream',
      'fileName'     => $this->sanitizeFileName($file->file_name),
      'date'         => $this->formatDate($file->date), // FIXME: Another date field inconsistency, hooray!
      'modified'     => $this->formatDate($file->file_modified),
      'size'         => (int)$file->size,
      'sha1Checksum' => $file->sha1_checksum,
      'text'         => $file->text,
      'accessURL'    => route('file.access', $file->id),
      'downloadURL'  => route('file.download', $file->id),

      // TODO: These are hard to implement, are they really necessary?
      // 'paper'        => $this->collectionRouteList('api.v1.paper.show', $file->papers),
      // 'meeting'      => $this->collectionRouteList('api.v1.meeting.show', $file->meetings),

      'masterFile'     => ($file->master_file_id) ? route('api.v1.file.show', $file->master_file_id) : null,
      'derivativeFile' => $this->collectionRouteList('api.v1.file.show', $file->derivatives),
      'license'        => $file->license,
      'fileRole'       => $file->role,
      'keyword'        => $file->keyword
    ];
  }

  public function includeMasterFile(File $file)
  {
    return $this->item($file->masterFile, new FileTransformer);
  }

  public function includeDerivativeFile(File $file)
  {
    return $this->collection($file->derivatives, new FileTransformer);
  }
}