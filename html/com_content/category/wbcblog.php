<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * * * 
 * zusätzliche Parameter:
 * 
 * $params->get('select_customfield'); // ausgewählte Felder
 * $params->get(trunc_introtext); // gekürzter Intro Text
 * $params->get('chars_number'); // Anzahl zeichen
 * $params->get('show_readmore_leading_item'); // Weiterlesen für Leadingartikel
 * $params->get('trunc_leadingtext'); // Leadingtext kürzen
 * $params->get('chars_number_leading'); // Anzahl zeichen
 * $params->get('linked_tags'); // Tags verlinken oder nicht 
 * $params->get('wbc_alternate_category_title'); // alternativer Kategorie Titel
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use \Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

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

if ($this->params->get('show_customfields') == 2) {
    $this->selectedFields = $this->params->get('select_customfield');
}

$this->readmore_leading_item = false;  // leadingbeiträge mit weiterlesen 
$this->readmore_intro_item = false;  // Intro mit weiterlesen 
// Custom Parameter for alternate category title
if (!empty($this->params->get('wbc_alternate_category_title') )) {
    $category_title = $this->params->get('wbc_alternate_category_title');
} else {
    $category_title = $this->category->title;
}
?> 

<div class="com-content-category-blog blog" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>
   
    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1) || $this->params->get('show_category_title', 1)) : ?>
        <div class="category-desc category-desc-row d-flex align-items-center mb-4">
          
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <picture class="wbc-categoryimg">
                <?php echo LayoutHelper::render(
                    'joomla.html.image',
                    [
                        'src' => $this->category->getParams()->get('image'),
                        'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                        'class' => 'p-3',
                    ]
                ); ?>
                </picture>
            <?php endif; ?>

            <?php if ($this->params->get('show_category_title', 1) || $this->params->get('show_description')) : ?>
            <div class="wbc-category-content">
                <?php if ($this->params->get('show_category_title', 1)) : ?>
                    <<?php echo $htag; ?> class="wbc-category-title">
                            <?php echo $category->title; ?> 
                    </<?php echo $htag; ?>>
                <?php endif; ?>
                <?php echo $afterDisplayTitle; ?>
                
                    <?php echo $beforeDisplayContent; ?>

                    <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                        <div class="wbc-category-text">
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
    
    <?php // Code to add a link to submit an article. ?>
    <?php if ($this->category->getParams()->get('access-create')) : ?>
        <?php echo HTMLHelper::_('contenticon.create', $this->category, $this->category->params, ['class' => 'wbc__create-btn mb-3']); ?>
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
                <?php $this->item = &$item; 
                if (!$this->params->get('show_readmore_leading_item')) { // kein weiterlesen für Leading Beiträge gesetzt
                        
                    $this->itemtext  = $this->item->introtext;
                    $this->itemtext .= $this->item->fulltext;
                } else {
                    $this->readmore_leading_item = true;
                    if ($this->params->get('trunc_leadingtext', 1)) {
                            $truncated_text = HTMLHelper::_('string.truncate', strip_tags($this->item->introtext), $this->params->get('chars_number_leading'));
                            $last_space = strrpos($truncated_text, " ");
                            $truncated_text = substr($truncated_text, 0, $last_space);
                            $this->itemtext =  '<p>' . $truncated_text . '</p>';
                        } else {
                            $this->itemtext = $this->item->introtext;
                        }
                }?>
                <?php $images     = json_decode($this->item->images); ?>
                <?php $imgclass   = empty($images->float_intro) ? 'image-'.$this->params->get('float_intro') : 'image-'.$images->float_intro; ?>
                <?php if ($this->params->get('readmore_leading_item') == 0 ) { // kein weiterlesen für Leading Beiträge gesetzt?>
                <?php    $this->readmore_leading_item = false; ?>  
                <?php } ?>
                <div class="com-content-category-blog__item blog-item <?php echo $this->escape($imgclass); ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($this->intro_items)) : ?>
        <?php $blogClass = $this->params->get('blog_class', ''); ?>
        <?php if ((int) $this->params->get('num_columns') > 1) : ?>
            <?php $blogClass .= (int) $this->params->get('multi_column_order', 0) === 0 ? ' masonry-' : ' columns-'; ?>
            <?php $blogClass .= (int) $this->params->get('num_columns'); ?>
        <?php endif; ?>
        <?php $this->readmore_leading_item = false; ?>  
        
        <div class="com-content-category-blog__items blog-items <?php echo $blogClass; ?>">
        <?php foreach ($this->intro_items as $key => &$item) : ?>
            <?php $this->item = &$item; 
            if (($this->params->get('show_readmore') && $this->item->readmore) || $this->params->get('trunc_introtext', 1)) :
                $this->readmore_intro_item = true;
            else: 
                $this->readmore_intro_item = false;    
            endif;
            
            if ($this->params->get('trunc_introtext', 1)) {
                $truncated_text = HTMLHelper::_('string.truncate', strip_tags($this->item->introtext), $this->params->get('chars_number'));
                $last_space = strrpos($truncated_text, " ");
                $truncated_text = substr($truncated_text, 0, $last_space);
                $this->itemtext =  '<p>' . $truncated_text . '</p>';
            } else {
                $this->itemtext = $this->item->introtext;
            } ?>
            <?php $images     = json_decode($this->item->images); ?>
            <?php $imgclass   = empty($images->float_intro) ? 'image-'.$this->params->get('float_intro') : 'image-'.$images->float_intro; ?>
            
            <div class="com-content-category-blog__item blog-item <?php echo $this->escape($imgclass); ?>">
                    <?php echo $this->loadTemplate('item');?>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($this->link_items)) : ?>
        <div class="items-more">
            <?php echo $this->loadTemplate('links'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
        <div class="com-content-category-blog__children cat-children">
            <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
                <h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
            <?php endif; ?>
            <?php echo $this->loadTemplate('children'); ?> </div>
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
