<?php namespace OParl\Fakers;

use \mPDF;

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
  /**
   * @var mPDF
   */
  protected $pdf = null;

  /**
   * Generates a PDF Skeleton including a header and a footer
   */
  protected function generateSkeleton(Body $body)
  {
    $this->pdf = new mPDF();
    $this->pdf->SetHTMLFooter('<p style="text-align:center; font-size: 6px;">'.$body->name.'</p>');
  }

  protected function finishPDF()
  {
    return $this->pdf->Output('', 'S');
  }

  public function oparlMeetingInvitation(Body $body, Meeting $meeting = null)
  {
    $this->generateSkeleton($body);

    $this->pdf->writeHTML("<h1>Einladung zur Besprechung - {$meeting->start_date}</h1>");
    foreach (range(1, $this->generator->numberBetween(1, 3)) as $paragraphNum)
    {
      $this->pdf->writeHTML("<p>{$this->generator->paragraph}</p>");
    }

    $list = "<ul>";
    foreach (range(1, $this->generator->numberBetween(1, 7)) as $listItem)
    {
      $list .= "<li>{$this->generator->sentence}</li>";
    }
    $list .= "</ul>";

    $this->pdf->writeHTML($list);

    $pdfData = $this->finishPDF();

    $filename = 'files/'.uniqid('file_').'.pdf';

    Storage::put($filename, $pdfData);

    return $filename;
  }
}