<?php
 /*************************************************************************
 *
 * TAN YEE SIANG CONFIDENTIAL
 * __________________
 *
 *  [2002] - [2007] TAN YEE SIANG
 *  All Rights Reserved.
 *
 * NOTICE:  All information contained herein is, and remains
 * the property of TAN YEE SIANG and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to TAN YEE SIANG
 * and its suppliers and may be covered by U.S. and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from TAN YEE SIANG.
 */
class ModelGenerator extends CCodeGenerator
{
	public $codeModel = 'gii.generators.model.ModelCode';

	/**
	 * Provides autocomplete table names
	 * @param string $db the database connection component id
	 * @return string the json array of tablenames that contains the entered term $q
	 */
	public function actionGetTableNames($db)
	{
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$all = array();
			if (!empty($db) && Yii::app()->hasComponent($db) !== false && (Yii::app()->getComponent($db) instanceof CDbConnection)) {
				$all = array_keys(Yii::app()->{$db}->schema->getTables());
			}

			echo json_encode($all);
		} else {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
	}
}
