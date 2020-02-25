<?php

class getResourceCategories extends Action
{
	public function run()
	{
		$tmps = HUB::getResourceCategories();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$childs = array();
				if (!empty($tmp['childs'])) {
					foreach ($tmp['childs'] as $child) {
						$childs[] = $child->toApi();
					}
					$tmp['childs'] = $childs;
				}
				$result[] = $tmp;
			}
		}

		$this->getController()->outputSuccess($result);
	}
}
