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
<div class="com-content-category-blog blog" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1)) : ?>
    <<?php echo $htag; ?>>
        <?php echo $this->category->title; ?>
    </<?php echo $htag; ?>>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc clearfix">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <?php echo LayoutHelper::render(
                    'joomla.html.image',
                    [
                        'src' => $this->category->getParams()->get('image'),
                        'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                    ]
                ); ?>
            <?php endif; ?>
            <?php echo $beforeDisplayContent; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
            <?php echo $afterDisplayContent; ?>
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
                <div class="com-content-category-blog__item blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $count_items = 0; ?>
    <?php $collapse_first_item = $this->params->get('collapse_first_item',0); ?>
    <?php if (!empty($this->intro_items)) : ?>
        <?php $blogClass = $this->params->get('blog_class', ''); ?>
        <div class="accordion accordion-flush <?php echo $blogClass; ?>" id="accordionBlog">
        <?php foreach ($this->intro_items as $key => &$item) : ?>
            <?php
                $canEdit = $item->params->get('access-edit');
                $count_items++;
                $is_collapsed = ($count_items == 1 && $collapse_first_item == 1) ? '' : 'collapsed';
                $currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
                $isUnpublished = ($item->state == ContentComponent::CONDITION_UNPUBLISHED || $item->publish_up > $currentDate) || ($item->publish_down < $currentDate && $item->publish_down !== null);
                $jcfieldId = $item->params->get('select_customfield');
                $jcfields = FieldsHelper::getFields('com_content.article', $item, true);
                foreach($jcfields as $jcfield) {
                  $jcfields[$jcfield->id] = $jcfield;
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
                        <?php if (!empty($jcfieldId) && (!empty($jcfields[$jcfieldId]->value))) : ?>
                            <?php echo $jcfields[$jcfieldId]->value; ?>
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

                        <?php if ($this->params->get('show_tags', 1) && !empty($item->tags->itemTags)) : ?>
                            <?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
                        <?php endif; ?>

                        <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
                        <?php echo $item->event->beforeDisplayContent; ?>

                        <?php echo LayoutHelper::render('joomla.content.intro_image', $item); ?>

                        <?php echo $item->introtext; ?>
                        <?php echo $item->fulltext; ?>

                        <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
                        <?php echo $item->event->afterDisplayContent; ?>

                    </div>
                </div>

                <?php if ($isUnpublished) : ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
