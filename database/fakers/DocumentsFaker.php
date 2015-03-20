<?php namespace OParl\Fakers;

use \mPDF;
use \View;

use Illuminate\Support\Facades\Storage;

use Faker\Provider\Base;

use OParl\Body;
use OParl\Meeting;

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

  public function oparlMeetingInvitation(Meeting $meeting)
  {
    $pdf = new mPDF();
    $pdf->ignore_invalid_utf8 = true;

    $view = View::make('documents.meeting_invitation', ['meeting' => $meeting]);
    $pdf->WriteHTML($view);

    return $this->save($pdf);
  }
}