<?php namespace OParl\Fakers;

use Carbon\Carbon;
use \mPDF;
use \View;

use Illuminate\Support\Facades\Storage;

use Faker\Provider\Base;

use OParl\Body;
use OParl\Meeting;
use OParl\File;

/**
 * Class DocumentsFaker
 *
 * Provide fakers that create pdf documents for the various use cases:
 *
 * - invitations,
 * - papers,
 * - protocols,
 * - ...
 *
 * @package OParl\Fakers
 */
class DocumentsFaker extends Base {

  protected function save(mPDF $pdf)
  {
    $pdfData = $pdf->Output('', 'S');
    $filename = 'files/'.uniqid('file_').'.pdf';

    Storage::put($filename, $pdfData);

    return $filename;
  }

  protected function makeDocument($view, $viewData, $fileCreated)
  {
    $pdf = new mPDF();
    $pdf->ignore_invalid_utf8 = true;

    $view = View::make($view, $viewData);
    $pdf->WriteHTML($view);

    $fileName = $this->save($pdf);

    $file = File::create([
      'file_name'     => $fileName,
      'file_modified' => Carbon::createFromTimestampUTC(Storage::lastModified($fileName)),
      'size'          => Storage::size($fileName),
      'file_created'  => $fileCreated,
      'name'          => $this->generator->optional()->word,
      'text'          => $this->generator->optional()->paragraphs(2),
      'mime_type'     => 'application/pdf',
    ]);

    return $file;
  }

  public function oparlMeetingInvitation(Meeting $meeting, Carbon $term_start, Carbon $term_end)
  {
    return $this->makeDocument(
      'documents.meeting_invitation',
      compact('meeting'),
      $this->generator->dateTimeBetween($term_start, $term_end)
    );
  }

  public function oparlPaper($name)
  {
    return $this->makeDocument(
      'documents.paper',
      compact('name'),
      Carbon::now()
    );
  }
}