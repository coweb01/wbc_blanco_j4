<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;


/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('com_content.form-edit');
 
$app          = Factory::getApplication();
$template     = $app->getTemplate();
$mediapath    = 'media/templates/site/'. $template .'/';
$wa->registerAndUseStyle('frontendedit', $mediapath . 'css/frontend_edit.css');

$user = $this->user;
$usergroups     = $user->groups; 
$groupIds       = $user->getAuthorisedGroups();
$isBuerger      = false;
foreach ($groupIds as $groupId) {
    $groupTable = Table::getInstance('Usergroup', 'JTable', array());
    $groupTable->load($groupId);
    if ($groupTable->title == 'Bürger') {
        $isBuerger = in_array($groupId, $usergroups);
        continue;
    }
}

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = ['image-intro', 'image-full', 'jmetadata', 'item_associations'];
$this->useCoreUI = true;

// Create shortcut to parameters.
$params = $this->state->get('params');

// LayoutData
$LayoutData['item'] = $this->item;
$LayoutData['form'] = $this->form;

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings
if (!$params->exists('show_publishing_options')) {
    $params->set('show_urls_images_frontend', '0');
}
?>
<div class="edit item-page edit-buerger">
    <?php if ($params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1>
            <?php echo $this->escape($params->get('page_heading')); ?>
        </h1>
    </div>
    <?php endif; ?>

    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
        <fieldset>

            <?php echo LayoutHelper::render('wbc_blanco_template.edit.buergercontent', $LayoutData); ?>           
            <?php echo LayoutHelper::render('wbc_blanco_template.edit.buergerparams', $this); ?>
            
            <input type="hidden" name="task" value="">
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>
        <div class="mb-2">
            <button type="button" class="btn btn-primary" data-submit-task="article.apply">
                <span class="icon-check" aria-hidden="true"></span>
                <?php echo Text::_('JSAVE'); ?>
            </button>
            <button type="button" class="btn btn-primary" data-submit-task="article.save">
                <span class="icon-check" aria-hidden="true"></span>
                <?php echo Text::_('JSAVEANDCLOSE'); ?>
            </button>
            <?php if ($this->showSaveAsCopy) : ?>
                <button type="button" class="btn btn-primary" data-submit-task="article.save2copy">
                    <span class="icon-copy" aria-hidden="true"></span>
                    <?php echo Text::_('JSAVEASCOPY'); ?>
                </button>
            <?php endif; ?>
            <button type="button" class="btn btn-danger" data-submit-task="article.cancel">
                <span class="icon-times" aria-hidden="true"></span>
                <?php echo Text::_('JCANCEL'); ?>
            </button>
            
            <?php if ($isBuerger === false ) : ?>
                <?php if ($params->get('save_history', 0) && $this->item->id) : ?>
                    <?php echo $this->form->getInput('contenthistory'); ?>
                <?php endif; ?>
            <?php endif; ?>        
        </div>
    </form>
</div>
