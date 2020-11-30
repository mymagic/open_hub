<?php

class CvSearchForm extends FormModel
{
	public $jobpos;
	public $looks;
	public $location;
	public $skillset;
	public $program;
	public $visibility;
	public $portfolioId;
	public $name;

	// Add a public property for each search form element here

	public function hasFilter()
	{
		if (!empty($this->jobpos) || !empty($this->looks) || !empty($this->location) || !empty($this->skillset) || !empty($this->program)) {
			return true;
		}

		return false;
	}

	public function rules()
	{
		return array(
			// You should validate your search parameters here
			array('jobpos, looks, location, skillset, program, name, visibility', 'safe'),
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('user', 'cvJobpos', 'state', 'country');
		$criteria->together = true;
		$criteria->addCondition('t.display_name IS NOT NULL AND t.display_name != ""');
		$criteria->compare('t.is_active', 1);
		$criteria->compare('user.is_active', 1);

		if ($this->visibility == 'private') {
			$criteria->addCondition(sprintf('(t.visibility = "protected" OR t.visibility = "public") OR t.visibility = "private" AND t.id=%s', $this->portfolioId));
		} elseif ($this->visibility == 'protected') {
			$criteria->addCondition('t.visibility = "protected" OR t.visibility = "public"');
		} else {
			$criteria->compare('t.visibility', 'public');
		}

		if (!empty($this->location)) {
			$criteria->addCondition(
				sprintf(
				't.organization_name LIKE "%%%s%%" OR t.location LIKE "%%%s%%" OR state.title LIKE "%%%s%%" OR state.code LIKE "%%%s%%" OR country.printable_name LIKE "%%%s%%"',
				$this->location,
				$this->location,
				$this->location,
				$this->location,
				$this->location
			)
			);
		}

		if (!empty($this->jobpos)) {
			$criteria->addInCondition('t.cv_jobpos_id', $this->jobpos);
		}

		if (!empty($this->looks)) {
			foreach ($this->looks as $look) {
				$criteria->compare('t.is_looking_' . $look, 1, 'OR');
			}
		}

		if (!empty($this->name)) {
			$criteria->addCondition('t.display_name LIKE "%' . $this->name . '%"', 'OR');
			$criteria->addCondition('t.slug LIKE "%' . $this->name . '%"');
		}

		return new CActiveDataProvider('CvPortfolio', array(
			'criteria' => $criteria,
			'sort' => array(
				//'defaultOrder'=>'t.date_modified DESC',
				//'defaultOrder' => 't.display_name ASC, t.date_modified DESC',
				//'defaultOrder'=>'if(t.image_avatar="" or t.image_avatar is null, 1, 0), t.image_avatar, SUBSTRING(t.display_name, 1, 1) ASC',
			),
			'pagination' => array(
				'pageSize' => 30,
			),
		));
	}
}
