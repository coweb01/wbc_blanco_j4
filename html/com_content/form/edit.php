<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Overrride Webconcept
 * Stand: 20.6.2024
 * Author: c.oerter
 * Version: 1.0
 * 
 * Für die Bürgebereiche wird ein angepasstes Formular angezeigt.
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
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('com_content.form-edit');

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = ['image-intro', 'image-full', 'jmetadata', 'item_associations'];
$this->useCoreUI = true;

// Create shortcut to parameters.
$params = $this->state->get('params');

$app          = Factory::getApplication();

// Frontend editing Buerger
$template     = $app->getTemplate();
$mediapath    = 'media/templates/site/'. $template .'/';
$wa->registerAndUseStyle('frontendedit', $mediapath . 'css/frontend_edit.css',[], [], ['template.wbc']);

$usergroups     = $this->user->groups; 
$groupIds       = $this->user->getAuthorisedGroups();
$isBuerger      = false;
foreach ($groupIds as $groupId) {
    $groupTable = Table::getInstance('Usergroup', 'JTable', array());
    $groupTable->load($groupId);
    if ($groupTable->title == 'Bürger') {
        $isBuerger = in_array($groupId, $usergroups);
        $formClass = "edit-buergerbereiche";
        continue;
    }
}
// Dateibrowser für Bürger deaktivieren
if ($isBuerger) {
    $wa->addInlineScript("
        document.addEventListener('DOMContentLoaded', function() {
        var buttons = document.querySelectorAll('.tf-gallery-actions .btn-group.add-button .add.dropdown-toggle');
        buttons.forEach(function(button) {
        button.disabled = true;
        });
    });
    ");
}
// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings
if (!$params->exists('show_publishing_options')) {
    $params->set('show_urls_images_frontend', '0');
}
?>
<div class="edit item-page <?php echo $formClass;?>">
    <?php if ($params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1>
            <?php echo $this->escape($params->get('page_heading')); ?>
        </h1>
    </div>
    <?php endif; ?>
    <?php if (!$isBuerger) : // normales Formular wird angezeigt ?>
    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
        <div class="my-3">
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
            <?php if ($params->get('save_history', 0) && $this->item->id) : ?>
                <?php echo $this->form->getInput('contenthistory'); ?>
            <?php endif; ?>
        </div>
        <fieldset>
            <?php echo HTMLHelper::_('uitab.startTabSet', $this->tab_name, ['active' => 'editor', 'recall' => true, 'breakpoint' => 768]); ?>

            <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'editor', Text::_('COM_CONTENT_ARTICLE_CONTENT')); ?>
                <?php echo $this->form->renderField('title'); ?>

                <?php if (is_null($this->item->id)) : ?>
                    <?php echo $this->form->renderField('alias'); ?>
                <?php endif; ?>

                <?php echo $this->form->renderField('articletext'); ?>

                <?php if ($this->captchaEnabled) : ?>
                    <?php echo $this->form->renderField('captcha'); ?>
                <?php endif; ?>
            <?php echo HTMLHelper::_('uitab.endTab'); ?>

            <?php if ($params->get('show_urls_images_frontend')) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'images', Text::_('COM_CONTENT_IMAGES_AND_URLS')); ?>
                <?php echo $this->form->renderField('image_intro', 'images'); ?>
                <?php echo $this->form->renderField('image_intro_alt', 'images'); ?>
                <?php echo $this->form->renderField('image_intro_alt_empty', 'images'); ?>
                <?php echo $this->form->renderField('image_intro_caption', 'images'); ?>
                <?php echo $this->form->renderField('float_intro', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext_alt', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext_alt_empty', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext_caption', 'images'); ?>
                <?php echo $this->form->renderField('float_fulltext', 'images'); ?>
                <?php echo $this->form->renderField('urla', 'urls'); ?>
                <?php echo $this->form->renderField('urlatext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targeta', 'urls'); ?>
                    </div>
                </div>
                <?php echo $this->form->renderField('urlb', 'urls'); ?>
                <?php echo $this->form->renderField('urlbtext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targetb', 'urls'); ?>
                    </div>
                </div>
                <?php echo $this->form->renderField('urlc', 'urls'); ?>
                <?php echo $this->form->renderField('urlctext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targetc', 'urls'); ?>
                    </div>
                </div>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php endif; ?>

            <?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

            <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'publishing', Text::_('COM_CONTENT_PUBLISHING')); ?>

                <?php echo $this->form->renderField('transition'); ?>
                <?php echo $this->form->renderField('state'); ?>
                <?php echo $this->form->renderField('catid'); ?>
                <?php echo $this->form->renderField('tags'); ?>
                <?php echo $this->form->renderField('note'); ?>
                <?php if ($params->get('save_history', 0)) : ?>
                    <?php echo $this->form->renderField('version_note'); ?>
                <?php endif; ?>
                <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                    <?php echo $this->form->renderField('created_by_alias'); ?>
                <?php endif; ?>
                <?php if ($this->item->params->get('access-change')) : ?>
                    <?php echo $this->form->renderField('featured'); ?>
                    <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                        <?php echo $this->form->renderField('featured_up'); ?>
                        <?php echo $this->form->renderField('featured_down'); ?>
                        <?php echo $this->form->renderField('publish_up'); ?>
                        <?php echo $this->form->renderField('publish_down'); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo $this->form->renderField('access'); ?>
                <?php if (is_null($this->item->id)) : ?>
                    <div class="control-group">
                        <div class="control-label">
                        </div>
                        <div class="controls">
                            <?php echo Text::_('COM_CONTENT_ORDERING'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php echo HTMLHelper::_('uitab.endTab'); ?>

            <?php if (Multilanguage::isEnabled()) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL')); ?>
                    <?php echo $this->form->renderField('language'); ?>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php else : ?>
                <?php echo $this->form->renderField('language'); ?>
            <?php endif; ?>

            <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'metadata', Text::_('COM_CONTENT_METADATA')); ?>
                    <?php echo $this->form->renderField('metadesc'); ?>
                    <?php echo $this->form->renderField('metakey'); ?>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php endif; ?>

            <?php echo HTMLHelper::_('uitab.endTabSet'); ?>

            <input type="hidden" name="task" value="">
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>
        <div class="my-3">
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
            <?php if ($params->get('save_history', 0) && $this->item->id) : ?>
                <?php echo $this->form->getInput('contenthistory'); ?>
            <?php endif; ?>
        </div>
    </form>
    <?php else : ?>
    <?php // Bürgerbereiche Formular wird angezeigt ?>
    <?php $layoutData['item'] = $this->item; ?>
    <?php $layoutData['data'] = $this; ?>
    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
        <div class="my-3">
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
            <?php if ($params->get('save_history', 0) && $this->item->id) : ?>
                <?php echo $this->form->getInput('contenthistory'); ?>
            <?php endif; ?>
        </div>
        <fieldset>
            <?php echo LayoutHelper::render('wbc_blanco_template.edit.buergercontent', $layoutData); ?>           
            <?php echo LayoutHelper::render('wbc_blanco_template.edit.buergerparams', $this); ?>
            <?php if ($this->captchaEnabled) : ?>
                <?php echo $this->form->renderField('captcha'); ?>
            <?php endif; ?>
            <input type="hidden" name="task" value="">
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>
        <div class="my-3">
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
        </div>
    </form>  
    <?php endif; ?>    
</div>