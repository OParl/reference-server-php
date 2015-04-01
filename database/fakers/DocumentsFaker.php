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

  public function oparlMeetingInvitation(Meeting $meeting, Carbon $term_start, Carbon $term_end)
  {
    $pdf = new mPDF();
    $pdf->ignore_invalid_utf8 = true;

    $view = View::make('documents.meeting_invitation', ['meeting' => $meeting]);
    $pdf->WriteHTML($view);

    $invitationFileName = $this->save($pdf);

    $invitationFile = File::create([
      'file_name'     => $invitationFileName,
      'file_modified' => Carbon::createFromTimestampUTC(Storage::lastModified($invitationFileName)),
      'size'          => Storage::size($invitationFileName),
      'file_created'  => static::$faker->dateTimeBetween($term_start, $term_end),
      'name'          => static::$faker->optional()->word,
      'text'          => static::$faker->optional()->paragraphs(2),
      'mime_type'     => 'application/pdf',
    ]);

    return $invitationFile;
  }
}