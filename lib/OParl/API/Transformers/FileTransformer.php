<?php namespace OParl\API\Transformers;

use OParl\Model\File;
use EFrane\Transfugio\Transformers\BaseTransformer;

/**
 * FileTransformer - Transform File Entities
 *
 * This transforms file entities. File access and download URLs
 * are added if the following config options are met:
 *
 * 1. oparl.files.enabled is true and
 * 2. oparl.files.accessRoute and oparl.files.downloadRoute contain valid route names
 *
 * @package OParl\API\Transformers
 **/
class FileTransformer extends BaseTransformer
{
  protected $availableIncludes = ['masterFile', 'derivativeFile'];

  public function transform(File $file)
  {
    $transformed = [
      'id' => route('api.v1.file.show', $file->id),
      'type' => 'http://oparl.org/schema/1.0/File',
      'name' => $file->name,
      'mimeType' => ($file->mime_type) ?: 'application/octet-stream',
      'fileName' => $file->sanitized_file_name,
      'size' => (int)$file->size,
      'sha1Checksum' => $file->sha1_checksum,
      'text' => $file->text,

      'accessURL' => null,
      'downloadURL' => null,

      // TODO: These are hard to implement, are they really necessary?
      // 'paper'        => $this->collectionRouteList('api.v1.paper.show', $file->papers),
      // 'meeting'      => $this->collectionRouteList('api.v1.meeting.show', $file->meetings),

      'masterFile' => ($file->master_file_id) ? route('api.v1.file.show', $file->master_file_id) : null,
      'derivativeFile' => $this->collectionRouteList('api.v1.file.show', $file->derivatives),
      'license' => $file->license,
      'fileRole' => $file->role,
      'keyword' => $file->keyword,

      'fileCreated' => $this->formatDate($file->file_created),
      'fileModified' => $this->formatDate($file->file_modified),

      'modified' => $this->formatDate($file->modified_at),
      'created' => $this->formatDate($file->created_at),
    ];

    if (config('oparl.files.enabled'))
    {
      $transformed['accessURL'] = route(config('oparl.files.accessRoute'), $file->id);
      $transformed['downloadURL'] = route(config('oparl.files.downloadRoute'), $file->id);
    }

    return $transformed;
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