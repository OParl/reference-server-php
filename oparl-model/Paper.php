<?php namespace OParl;

class Paper extends BaseModel {

	public function body()
  {
    return $this->belongsTo('OParl\Body');
  }

  public function relatedPapers()
  {
    return $this->belongsToMany('OParl\Paper', 'papers_related_papers', 'paper_id', 'related_id');
  }

  public function auxiliaryFiles()
  {
    return $this->belongsToMany('OParl\Paper', 'papers_auxiliary_files', 'paper_id', 'auxiliary_id');
  }

  public function consultations()
  {
    return $this->belongsToMany('OParl\Consultation', 'papers_consultations', 'paper_id', 'consultation_id');
  }
}
