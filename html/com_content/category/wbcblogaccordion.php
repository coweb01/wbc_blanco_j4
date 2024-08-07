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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use \Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

HTMLHelper::_('bootstrap.collapse');

$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayContent = trim(implode("\n", $results));

$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

?>
<div class="com-content-category-blog blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1) || $this->params->get('show_category_title', 1)) : ?>
        <div class="category-desc d-flex align-items-center mb-4">
          
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <picture class="p-3">
                <?php echo LayoutHelper::render(
                    'joomla.html.image',
                    [
                        'src' => $this->category->getParams()->get('image'),
                        'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                        'class' => 'wbc-categoryimg',
                    ]
                ); ?>
                </picture>
            <?php endif; ?>

            <?php if ($this->params->get('show_category_title', 1) || ($this->params->get('show_description') && $this->category->description)) : ?>
            <div class="flex-grow-1">
                <?php if ($this->params->get('show_category_title', 1)) : ?>
                    <<?php echo $htag; ?> class="wbc__category-title">
                        <?php echo $this->category->title; ?> 
                    </<?php echo $htag; ?>>  
                <?php endif; ?>
                <?php echo $afterDisplayTitle; ?>
                
                    <?php echo $beforeDisplayContent; ?>

                    <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                        <div class="wbc-category-desc">
                            <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo $afterDisplayContent; ?>
                
            </div>
            <?php endif;?>    

            <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
                <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
                <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
        <?php if ($this->params->get('show_no_articles', 1)) : ?>
            <div class="alert alert-info">
                <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
                    <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($this->lead_items)) : ?>
        <div class="com-content-category-blog__items blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>">
            <?php foreach ($this->lead_items as &$item) : ?>
                <div class="com-content-category-blog__item blog-item wbc-blog-item">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php // Accordion Items ?>            
    <?php $count_items = 0; ?>
    <?php $collapse_first_item = $this->params->get('collapse_first_item',0); ?>
    <?php if (!empty($this->intro_items)) : ?>
        <?php $blogClass = $this->params->get('blog_class', ''); ?>
        <div class="accordion accordion-flush <?php echo $blogClass; ?>" id="accordionBlog">
        <?php foreach ($this->intro_items as $key => &$item) : ?>
            <?php
                $info    = $this->params->get('info_block_position', 0);
                $canEdit = $item->params->get('access-edit');
                $is_collapsed = ($count_items == 1 && $collapse_first_item == 1) ? '' : 'collapsed';
                $currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
                $isUnpublished = ($item->state == ContentComponent::CONDITION_UNPUBLISHED || $item->publish_up > $currentDate) || ($item->publish_down < $currentDate && $item->publish_down !== null);
                $count_items++;

                // Selected custom fields for Accordion Title
                if (!empty($item->params->get('select_customfield'))){  
                    $selectfield = array();
                    $selectfield = $item->params->get('select_customfield');
                    foreach ($selectfield as $key => $value) {
                        $selectfield[$value]['fieldid'] = $value;
                    }
                    $jcfields = FieldsHelper::getFields('com_content.article', $item, true);
                    foreach($jcfields as $jcfield) {
                        if (isset($jcfield->subform_rows)) {
                            foreach($jcfield->subform_rows as $row) {
                                foreach($row as $subfield) {
                                    if (in_array($subfield->id, $selectfield)) {
                                        $selectfield[$subfield->id]['field'] = $subfield;
                                    }
                                }
                            }
                        }
                        if (in_array($jcfield->id, $selectfield)) {
                            $selectfield[$subfield->id]['field'] = $jcfield;
                        }
                    } 
                }
            ?>

            <div class="accordion-item clearfix"
                itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                <?php if ($isUnpublished) : ?>
                    <div class="system-unpublished">
                <?php endif; ?>

                <h2 class="accordion-header" itemprop="name">
                    <button class="accordion-button <?php echo ($count_items == 1 && $collapse_first_item == 1) ? '' : 'collapsed'; ?>" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $item->id; ?>" aria-expanded="<?php echo ($count_items == 1 && $collapse_first_item == 1) ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $item->id; ?>">
                    <?php if (!empty($selectfield)) : ?>
                            <?php foreach ($selectfield as $key => $sf) : ?> 
                                <?php $render_class = 'wbc-field '; ?>
                                <?php if ( is_array($sf) ) : ?>
                                    <?php $render_class .= ' field-'.$sf['field']->fieldname; ?>
                                    <span class="<?php echo $render_class;?>"><?php echo $sf['field']->value; ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php echo $this->escape($item->title); ?>
                    <?php endif; ?>
                    </button>
                </h2>

                <div id="collapse-<?php echo $item->id; ?>" class="accordion-collapse collapse <?php echo ($count_items == 1 && $collapse_first_item == 1) ? 'show' : ''; ?>" data-bs-parent="#accordionBlog">
                    <div class="accordion-body">
                        <?php if ($canEdit) : ?>
                        <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $item->params, 'item' => $item]); ?>
                        <?php endif; ?>

                        <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
                        <?php echo $item->event->afterDisplayTitle; ?>

                        <?php if ( ($info == 0 || $info == 2) && $this->params->get('show_tags', 1) && !empty($item->tags->itemTags)) : ?>                        
                            <?php if($this->params->get('linked_tags',1)) : ?>
                                    <?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
                                <?php else : ?>
                                    <?php echo LayoutHelper::render('joomla.content.wbctags', $item->tags->itemTags); ?>
                            <?php endif; ?>   
                        <?php endif; ?>
                            
                        <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
                        <?php echo $item->event->beforeDisplayContent; ?>
                        <div class="flex-inhalt d-md-flex flex-md-row">  
                            <?php echo LayoutHelper::render('joomla.content.intro_image', $item); ?>
                            <div class="item-content">
                                <?php echo $item->introtext; ?>
                                <?php echo $item->fulltext; ?>
                            </div>
                        </div>      
                        <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
                        <?php echo $item->event->afterDisplayContent; ?>

                        <?php if ($info == 1 && $this->params->get('show_tags', 1) && !empty($item->tags->itemTags)) : ?>
                            <?php if($this->params->get('linked_tags',1)) : ?>
                                    <?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
                                <?php else : ?>
                                    <?php echo LayoutHelper::render('joomla.content.wbctags', $item->tags->itemTags); ?>
                            <?php endif; ?>   
                        <?php endif; ?>    
                    </div>
                </div>

                <?php if ($isUnpublished) : ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
   
    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
        <div class="com-content-category-blog__navigation w-100">
            <div class="com-content-category-blog__pagination">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="com-content-category-blog__counter counter small text-center">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
