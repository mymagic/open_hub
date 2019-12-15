<?php

class IdeaRfp2Enterprise extends IdeaRfp2EnterpriseBase
{
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'ideaRfp' => array(self::BELONGS_TO, 'IdeaRfp', 'idea_rfp_id'),
		);
	}
}
