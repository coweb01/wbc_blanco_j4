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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

// Create a shortcut for params.
$params  = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
    || ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);


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

    // wenn nur ein Feld ausgegeben wird, dann keine Tabs!
    if (is_array($htmlausgabe)) {
        $noTabs = (count($htmlausgabe) == 1 && $params->get('layout_customfields') == 1) ? true : false;
    }
}

?>
<div class="flex-inhalt">
    <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
    <?php if ($isUnpublished) : ?>
        <div class="system-unpublished">
    <?php endif; ?>

    <div class="item-content">
        <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

        <?php if ($canEdit) : ?>
            <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $params, 'item' => $this->item]); ?>
        <?php endif; ?>

        <?php // @todo Not that elegant would be nice to group the params ?>
        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
            || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

        <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
            <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'above']); ?>
        <?php endif; ?>
        <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php if($params->get('linked_tags',1)) : ?>
                <?php echo LayoutHelper::render('joomla.content.tags', ['item' => $this->item, 'params' => $params, 'tags' => $this->item->tags->itemTags]); ?>
            <?php else : ?>
                <?php echo LayoutHelper::render('joomla.content.wbctags', $this->item->tags->itemTags); ?>
            <?php endif; ?>       
        <?php endif; ?>

        <?php if (!$params->get('show_intro')) : ?>

            <?php // Content is generated by content plugin event "onContentAfterTitle"  ?>
            <?php if ($noTabs) {
                echo $this->item->event->afterDisplayTitle;
            }  else { ?>
            <?php foreach ( $fields as $field) : ?>
                <?php if ( $field->params->get('display') == 1 ) : ?>
                    <?php echo FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php } ?>

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

        <?php if ($this->readmore_leading_item === false){ ?>
        <?php     echo $this->item->introtext; ?>
        <?php     echo $this->item->fulltext; ?>
        <?php } else {?>       
            <?php if ($params->get('trunc_introtext', 1)) {
                $truncated_text = HTMLHelper::_('string.truncate', strip_tags($this->item->introtext), $params->get('chars_number'));
                $last_space = strrpos($truncated_text, " ");
                $truncated_text = substr($truncated_text, 0, $last_space);
                echo '<p>' . $truncated_text . '</p>';
                } else {
                    echo $this->item->introtext;
                }
            ?>
        <?php } ?>    
      
        <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
        <?php if ($noTabs) {
            echo $this->item->event->afterDisplayContent;
        }  else { ?>
        <?php foreach ( $fields as $field) : ?>
            <?php if ( $field->params->get('display') == 3 ) : ?>
                <?php echo FieldsHelper::render($field->context, 'field.'.$field->params->get('layout','render'), array('field' => $field)); ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php } ?>
        
        <?php if ( $this->readmore_leading_item  === true) { // KZ Leadbeitrag und weiterlesen  ?>
            <?php if (($params->get('show_readmore') && $this->item->readmore) || ($params->get('trunc_introtext') == 1 && $params->get('show_readmore'))) :
                if ($params->get('access-view')) :
                    $link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
                else :
                    $menu = Factory::getApplication()->getMenu();
                    $active = $menu->getActive();
                    $itemId = $active->id;
                    $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
                    $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
                endif; ?>

                <?php echo LayoutHelper::render('joomla.content.readmore', ['item' => $this->item, 'params' => $params, 'link' => $link]); ?>

            <?php endif; ?>
        <?php } ?>

        <?php if ($info == 1 || $info == 2) : ?>
            <?php if ($useDefList) : ?>
                <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'below']); ?>
            <?php endif; ?>
            <?php if($params->get('linked_tags',1)) : ?>
                <?php echo LayoutHelper::render('joomla.content.tags', ['item' => $this->item, 'params' => $params, 'tags' => $this->item->tags->itemTags]); ?>
            <?php else : ?>
                <?php echo LayoutHelper::render('joomla.content.wbctags', $this->item->tags->itemTags); ?>
            <?php endif; ?>
        <?php endif; ?>

        </div>
        <?php if ( $noTabs == false && count($htmlausgabe) > 0 ) : ?>
            <div class="fields">
                <?php echo LayoutHelper::render('wbc_blanco_template.accordiontabsub', $tabsdata); ?>
            </div>
        <?php endif; ?>
    <?php if ($isUnpublished) : ?>
        </div>
    <?php endif; ?>
</div>