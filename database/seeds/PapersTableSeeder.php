<?php

use Carbon\Carbon;

use OParl\Model\Paper;
use OParl\Model\Consultation;
use OParl\Model\AgendaItem;

/**
 * Class PapersTableSeeder
 * seeds Papers and Consultations, alters AgendaItems
 */
class PapersTableSeeder extends Seeder
{
  public function run()
  {
    $items = AgendaItem::where('name', 'like', 'Besprechung DRS %')->get();

    foreach ($items as $item)
    {
      $paperName = explode(' ', $item->name)[2];
      $paper = Paper::whereName($paperName)->first();
      if (is_null($paper))
      {
        $paperFile = static::$faker->oparlPaper($paperName);
        $paper = Paper::create([
          'name'    => $paperName,
          'body_id' => $item->meeting->organization->body_id,
          'published_date' => Carbon::now(),
          'main_file_id'   => $paperFile->id
        ]);
      }

       Consultation::create([
         'paper_id' => $paper->id,
         'agenda_item_id' => $item->id,

         'authoritative' => static::$faker->optional()->boolean(),
       ]);
    }
  }
}