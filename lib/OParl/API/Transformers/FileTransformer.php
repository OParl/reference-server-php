<?php namespace OParl\API\Transformers;

use OParl\Model\File;
use EFrane\Transfugio\Transformers\BaseTransformer;

class FileTransformer extends BaseTransformer
{
  protected $availableIncludes = ['masterFile', 'derivativeFile'];

  public function transform(File $file)
  {
    return [
      'id'           => route('api.v1.file.show', $file->id),
      'type'         => 'http://oparl.org/schema/1.0/File',
      'name'         => $file->name,
      'mimeType'     => ($file->mime_type) ?: 'application/octet-stream',
      'fileName'     => $file->getCleanFileName(),
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
      'keyword'        => $file->keyword,

      'fileCreated'  => $this->formatDate($file->file_created),
      'fileModified' => $this->formatDate($file->file_modified),

      'modified'    => $this->formatDate($file->modified_at),
      'created'     => $this->formatDate($file->created_at),
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