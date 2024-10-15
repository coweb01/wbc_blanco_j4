<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;


// Create shortcuts to some parameters.
$params  = $this->item->params;
$canEdit = $params->get('access-edit');
$user    = $this->getCurrentUser();
$info    = $params->get('info_block_position', 0);
$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

// Check if associations are implemented. If they are, define the parameter.
$assocParam        = (Associations::isEnabled() && $params->get('show_associations'));
$currentDate       = Factory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired         = !is_null($this->item->publish_down) && $this->item->publish_down < $currentDate;

// Vorbereitung der Custumfields für die Ausgabe als Tab / Accordion
$fields             = $this->item->jcfields; // Felder des Artikels holen formatierte Ausgabe 
$selectedFields     = $params->get('select_customfield');
$noTabs             = true;
$htmlausgabe        = array();
$i                  = 0;

if ($selectedFields) {
    $fields_tabs_pos = array();
    if (isset($selectedFields)) {
        foreach ($fields as $key => $field) {
            //  alle Felder aus der dem Array entfernen die nicht ausgewählt sind.
            if (in_array($field->id, $selectedFields)) { // wenn nicht in der Liste der ausgewählten Felder
                $field_tabs_pos[$field->id] = $fields[$key];
                unset($fields[$key]);
            } 
        }
    }
    // die Werte für Tabs/ Accordion in ein Array für die Ausgabe übergeben
    $i2 = 1;
    foreach ($field_tabs_pos as $field) {
        $contactfield = preg_match('/kontakt/', $field->name);
        $tabfields =  preg_match('/tab/', $field->name);
       
        switch ($field->type == 'subform') {
            case 'subform':
                if (!isset($field->subform_rows)) {
                    break;
                }
                if ($field->subform_rows) {  // wenn Subform 
                    
                    foreach ($field->subform_rows as $subform_row) {
                        // alle Subfields, wenn es repeatable fields sind
                        $i2 = 1;
                        if (!$tabfields) { 
                            // alle Felder aus dem Subfeld ausser (additional-infos-tab) mit dem dort hinterlegtem layout ausgeben.
                            if ($contactfield) {
                                $index = '0'. '-' . $field->name;
                            } else { $index = $i2. '-' . $field->name; $i2++;}
                           
                            $htmlausgabe[$index]['content'] = FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); 
                            $htmlausgabe[$index]['headline'] = $field->label;
                            
                        } else {
                            // alle Felder aus dem Subfeld tabs zusatzinfos
                            foreach ($subform_row as $fieldrow) {
                                $index = '9999'. '-' .$field->name. '-' . $i;
                                if (strpos($fieldrow->fieldname, 'content') && $fieldrow->value != '') { // nur wenn Inhalt vorhanden
                                    $htmlausgabe[$index]['content'] = $fieldrow->value;
                                } 
                                if (strpos($fieldrow->fieldname, 'headline') && $fieldrow->value != '') {
                                    $htmlausgabe[$index]['headline'] = $fieldrow->value;
                                } 
                            }
                        }

                        if ( !empty($htmlausgabe[$index]['content']) ) {
                            if ( empty($htmlausgabe[$index]['headline']) ) {
                                $htmlausgabe[$index]['headline'] = $field->label . '-' . $i;
                            }
                            $htmlausgabe[$index]['id'] = $field->id . '-' . $i;
                            $i++;
                        }
                    }
                } 
                break;
            default:
                if ( !empty($field->value) ) {
                    $index = $i2. '-' . $field->name;
                    $htmlausgabe[$index]['content'] =  $field->value;
                    $htmlausgabe[$index]['headline'] = $field->label;
                    $htmlausgabe[$index]['id'] = $field->id;
                    $i2++;
                }
        }    

    }

    // Daten für die Ausgabe der Tabs
    $tabsdata = (object) [ 'item' => $this->item, 
                            'params' => $params, 
                            'htmlausgabe' => $htmlausgabe
                        ];

    // wenn nur ein Feld ausgegeben wird, dann keine Tabs ausgeben!
    if (is_array($htmlausgabe)) {
        $noTabs = (count($htmlausgabe) == 1 && $params->get('layout_customfields') == 1) ? true : false;
    }
}

?>
<div class="com-content-article item-page<?php echo $this->pageclass_sfx; ?>">
    <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? Factory::getApplication()->get('language') : $this->item->language; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
    </div>
    <?php endif;
    if (!empty($this->item->pagination) && !$this->item->paginationposition && $this->item->paginationrelative) {
        echo $this->item->pagination;
    }
    ?>

    <?php $useDefList = $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
    || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam; ?>

    <?php if ($params->get('show_title')) : ?>
    <div class="page-header">
        <<?php echo $htag; ?>>
            <?php echo $this->escape($this->item->title); ?>
        </<?php echo $htag; ?>>
        <?php if ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED) : ?>
            <span class="badge bg-warning text-light"><?php echo Text::_('JUNPUBLISHED'); ?></span>
        <?php endif; ?>
        <?php if ($isNotPublishedYet) : ?>
            <span class="badge bg-warning text-light"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
        <?php endif; ?>
        <?php if ($isExpired) : ?>
            <span class="badge bg-warning text-light"><?php echo Text::_('JEXPIRED'); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($canEdit) : ?>
        <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $params, 'item' => $this->item]); ?>
    <?php endif; ?>
  
    <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
        <?php if ($noTabs) { 
            echo $this->item->event->afterDisplayTitle;
        }  else { ?>
        <?php foreach ( $fields as $field) : ?>
            <?php if ( $field->params->get('display') == 1 ) : ?>
                <?php echo FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); ?>
            <?php endif; ?>    
        <?php endforeach; ?> 
        <?php } ?>


    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
        <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'above']); ?>
    <?php endif; ?>

    <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
        <?php if($params->get('tags_linked')) : ?>
            <?php echo LayoutHelper::render('joomla.content.tags',  $this->item->tags->itemTags); ?>
        <?php else : ?>
            <?php echo LayoutHelper::render('joomla.content.wbctags', $this->item->tags->itemTags); ?>
        <?php endif; ?>      
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
    <?php if ($noTabs) {
        echo $this->item->event->beforeDisplayContent;
    }  else { ?>
    <?php foreach ( $fields as $field) : ?>
        <?php if ( $field->params->get('display') == 2 ) : ?>
            <?php echo FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); ?>
        <?php endif; ?>    
    <?php endforeach; ?> 
    <?php } ?>

    <?php if ((int) $params->get('urls_position', 0) === 0) : ?>
        <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php if ($params->get('access-view')) : ?>
        <?php echo LayoutHelper::render('joomla.content.full_image', $this->item); ?>
        <?php
        if (!empty($this->item->pagination) && !$this->item->paginationposition && !$this->item->paginationrelative) :
            echo $this->item->pagination;
        endif;
        ?>
        <?php if (isset($this->item->toc)) :
            echo $this->item->toc;
        endif; ?>
    <div class="com-content-article__body">
        <?php echo $this->item->text; ?>
    </div>

    <?php if ($noTabs) {
        echo $this->item->event->afterDisplayContent;
    }  else { ?>
    <?php foreach ( $fields as $field) : ?>
        <?php if ( $field->params->get('display') == 3 ) : ?>
            <?php echo FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); ?>
        <?php endif; ?>    
    <?php endforeach; ?> 
    <?php } ?>

    <?php // nur ausgewählte Felder werden als Accordion / Tab gerendert ?>
    <?php echo LayoutHelper::render('wbc_blanco_template.accordiontabsub', $tabsdata); ?>

    <?php if ($info == 1 || $info == 2) : ?>
        <?php if ($useDefList) : ?>
            <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'below']); ?>
        <?php endif; ?>
        <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php if($params->get('tags_linked')) : ?>
                <?php echo LayoutHelper::render('joomla.content.tags',  $this->item->tags->itemTags); ?>
            <?php else : ?>
                <?php echo LayoutHelper::render('joomla.content.wbctags', $this->item->tags->itemTags); ?>
            <?php endif; ?>      
        <?php endif; ?>
    <?php endif; ?>

    <?php
    if (!empty($this->item->pagination) && $this->item->paginationposition && !$this->item->paginationrelative) :
        echo $this->item->pagination;
        ?>
    <?php endif; ?>
    <?php if ((int) $params->get('urls_position', 0) === 1) : ?>
        <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php // Optional teaser intro text for guests ?>
    <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
        <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
        <?php echo HTMLHelper::_('content.prepare', $this->item->introtext); ?>
        <?php // Optional link to let them register to see the whole article. ?>
        <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
            <?php $menu = Factory::getApplication()->getMenu(); ?>
            <?php $active = $menu->getActive(); ?>
            <?php $itemId = $active->id; ?>
            <?php $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
            <?php $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
            <?php echo LayoutHelper::render('joomla.content.readmore', ['item' => $this->item, 'params' => $params, 'link' => $link]); ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    if (!empty($this->item->pagination) && $this->item->paginationposition && $this->item->paginationrelative) :
        echo $this->item->pagination;
        ?>
    <?php endif; ?>
</div>