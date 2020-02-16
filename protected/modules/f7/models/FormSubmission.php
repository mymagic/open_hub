<?php

class FormSubmission extends FormSubmissionBase
{
	public $searchIntake;

	public static function model($class = __CLASS__){return parent::model($class);}

	public function init()
	{
		// custom code here
		// ...
		
		parent::init();

		// return void
	}

	public function beforeValidate() 
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate() 
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...
		
		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...
		
		parent::afterFind();
		
		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}

	public function scopes()
    {
		return array
		(
			'draft'=>array('condition'=>"t.status = 'draft"),
			'submit'=>array('condition'=>"t.status = 'submit"),


		);
	}
	

	public function getEnumStage($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumStage(''));
		
		$stages = $this->form->jsonArray_stage;
		if(!empty($stages))
		{
			foreach($stages as $stage)
			{
				$result[] = array('code'=>$stage->key, 'title'=>$this->formatEnumStage($stage->key));
			}
		}

		$result[] = array('code'=>'submit', 'title'=>$this->formatEnumStatus('submit'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumStage($code)
	{
		$stages = $this->form->jsonArray_stage;
		if(!empty($stages))
		{
			foreach($stages as $stage)
			{
				if($stage->key == $code) return $stage->title;
			}
		}
		
		return '';
	}

	public function renderJsonData($mode='html')
	{
		if($mode == 'html')
		{
			$return = HubForm::convertJsonToHtml(false, $this->form->json_structure, $this->json_data, $this->form->slug, null, $this->jsonArray_data->EventID);
		}
		elseif($mode == 'csv')
		{
			$values = $headers = $return = array();
			$exportableCsvTags = array('textbox', 'number', 'url', 'email', 'phone', 'list', 'googleplace', 'upload', 'textarea', 'rating', 'radio', 'checkbox');
			
			// prepand extra data about the submission
			$headers[] = 'ID'; $values[] = $this->id;
			$headers[] = 'Code'; $values[] = $this->code;
			$headers[] = 'From'; $values[] = !empty($this->user)?$this->user->username:'-';
			$headers[] = 'Stage'; $values[] = $this->formatEnumStage($this->stage);
			$headers[] = 'Status'; $values[] = $this->formatEnumStatus($this->status);
			$headers[] = 'Date Submitted'; $values[] = Html::formatDateTimezone($this->date_submitted,  'long', 'medium', '-', $this->form->timezone);

			foreach($this->form->jsonArray_structure as $structureItem)
			{	
				if(is_object($structureItem) && property_exists($structureItem, 'members'))
				{
					foreach($structureItem->members as $structureItemMember)
					{
							
						if(!empty($structureItemMember->tag) && !empty($structureItemMember->prop) && in_array($structureItemMember->tag,  $exportableCsvTags))
						{
							// $structureItemMember->prop->name eg: startup, website, fname, heard...
							if(!empty($structureItemMember->prop->csv_label))
								$headers[] = $structureItemMember->prop->csv_label;
							else
								$headers[] = $structureItemMember->prop->name;

							//$values[] = $structureItemMember->prop->value;
							if ($structureItemMember->tag == 'upload')
							{
								$values[] = Yii::app()->createAbsoluteUrl('/f7/publish/download/' . basename($this->jsonArray_data->{'uploadfile.aws_path'}));
							}
							else
								$values[] = sprintf("%s", $this->jsonArray_data->{$structureItemMember->prop->name});
						}
					
					}
				}
					
			}
			$return = array($headers, $values);
			return $return;
		}
		elseif($mode == 'debug')
		{
			//echo '<pre>';print_r($this->form->jsonArray_structure) ;
		}
		
		return $return;
		
		//echo '<pre>';print_r($jsonStructure);exit;
	}
	

	public function formatEnumStatus($code)
	{
		switch($code)
		{
			
			case 'draft': {return Yii::t('app', 'Draft'); break;}
			
			case 'submit': {return Yii::t('app', 'Submitted'); break;}
			default: {return ''; break;}
		}
	}

	public function renderBackendDetails($mode='html')
	{
		$showableDetailTags = array('textbox', 'email', 'list');

		$buffer = '';
		//echo '<pre>';print_R($this->form->jsonArray_structure);exit;
		foreach($this->form->jsonArray_structure as $structureItem)
		{	
			if(is_object($structureItem) && property_exists($structureItem, 'members'))
			{
				foreach($structureItem->members as $structureItemMember)
				{
					if(!empty($structureItemMember->tag) && !empty($structureItemMember->prop) && in_array($structureItemMember->tag,  $showableDetailTags))
					{
						if($structureItemMember->prop->showinbackendlist == 1)
						{
							$buffer .= sprintf("<b>%s:</b> %s\n", 
							$structureItemMember->prop->csv_label,$this->jsonArray_data->{$structureItemMember->prop->name});
						}
					}
				}
			}
				
		}

		if($mode == 'html') $buffer = nl2br($buffer);

		if(!empty($buffer)) 
			return $buffer; 
		else 
			return '-';
	}

	public function renderSimpleFormattedHtml()
	{
		$contentList = $this->renderJsonData('csv');
		$combinedList = array_combine($contentList[0], $contentList[1]);
		$excludeItems = array('Code');
		
		$return = '';

		foreach($combinedList as $key=>$value)
		{
			if (in_array($key, $excludeItems) || trim($value) == '') continue;
			$return .= sprintf('<p><b>%s</b><br />%s</p>', $key, nl2br($value));
		}

		$return = sprintf('<div>%s</div>', $return);
			
		return $return;
	}

	
}
