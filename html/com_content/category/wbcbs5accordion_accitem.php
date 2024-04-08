<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * 
 * Es wird zum Beitrag verlinkt, wenn der Parameter linked Titles auf Ja steht.
 * Ansonsten wird der Beitragstext ausgegeben.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\CMS\HTML\HTMLHelper;


// Create a shortcut for params.
$params      = $this->item->params;
$canEdit     = $this->item->params->get('access-edit');
$info        = $params->get('info_block_position', 0);
$link_titles = $params->get('link_titles',0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
    || ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);


//  nur ausgewählte Felder nachInhalt oder ohne Anzeige 
if ($params->get('show_customfields') == 2) {
    $fieldscontent = '';
    $fields  = FieldsHelper::getFields('com_content.article', $this->item, true); // Felder des Artikels holen formatierte Ausgabe 
    foreach ($fields as $key => $field) {
        $display = $field->params->get('display');
        if (isset($this->selectedFields)) {
            if (!in_array($field->id, $this->selectedFields)) {
               unset($fields[$key]);
            } else if ( $display == 1 || $display == 2 ) {
               unset($fields[$key]); 
            }
        }
    }
}
/* Kompletten Beitragstext holen */
$app          = Factory::getApplication();
$mvcFactory   = $app->bootComponent('com_content')->getMVCFactory();
$articleModel = $mvcFactory->createModel('Article', 'Administrator', ['ignore_request' => true]);
$Contentitem  = $articleModel->getItem($this->item->id);
$fulltext     = str_replace('<hr id="system-readmore">', '', $Contentitem->articletext);
?>
                    
<?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>

<div class="wbc__accitem-content accordion-body">
    <?php if ($isUnpublished) : ?>
        <div class="system-unpublished">
    <?php endif; ?>
    
    <?php if ($canEdit) :   ?>
        <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $params, 'item' => $this->item]); ?>
    <?php endif; ?>

    <?php // @todo Not that elegant would be nice to group the params ?>
    <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
        || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
        <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'above']); ?>
    <?php endif; ?>
    <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
        <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
    <?php endif; ?>

    <?php if (!$params->get('show_intro')) : ?>
        <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
        <?php echo $this->item->event->afterDisplayTitle; ?>
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
    <?php echo $this->item->event->beforeDisplayContent; ?>
    <?php if ( $link_titles ) { ?>
            
        <a class="wbc__itemlink" href="<?php echo Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); ?>">
            <p class="d-flex justify-content-between h4"><span><?php echo $this->escape($this->item->title); ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            </p>
        </a>
            
    <?php  } else { ?>
        <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item);?>
        
        <?php echo HTMLHelper::_('content.prepare', $fulltext);?>

        <?php /* Ausgabe Customfields */ ?>
        <?php switch($params->get('show_customfields')) : 
        case 1: 
            // Content is generated by content plugin event "onContentAfterDisplay" alle Felder
            echo $this->item->event->afterDisplayContent; 
            break; 
        case 2:   
            // nur ausgewählte Felder werden gerendert       
            echo FieldsHelper::render('com_content.article', 'fields.render', ['item' => $this->item, 'context' => 'com_content.article', 'fields' => $fields]);
            break; ?>
        <?php endswitch; ?>   
   
        <?php if ($info == 1 || $info == 2) : ?>
            <?php if ($useDefList) : ?>
                <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'below']); ?>
            <?php endif; ?>
            <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
            <?php endif; ?>
        <?php endif; ?>
    
        <?php if ($isUnpublished) : ?>
            </div>
        <?php endif; ?>

        <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
        <?php //echo $this->item->event->afterDisplayContent; ?>
    <?php } ?>  
</div>