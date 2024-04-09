<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$app       = Factory::getApplication();
$form      = $displayData['form'];
$fieldSets = $form->getFieldsets();
$item    = $displayData['item'];
if (empty($fieldSets)) {
    return;
}

echo $form->renderField('title'); 
echo $form->renderField('catid'); 
if (is_null($item->id)) : 
    echo $form->renderField('alias'); 
endif; 

echo $form->renderField('articletext'); 

if ($displayData->captchaEnabled) : 
   echo $form->renderField('captcha'); 
endif; 