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
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	Yii::t('backend', 'Create'),
);\n";
?>

<?php echo ($this->buildSetting->getMenu('create', $this)); ?>
?>

<h1><?php $tmp = ($this->class2name($this->modelClass)); echo "<?php echo Yii::t('backend', 'Create {$tmp}'); ?>" ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
