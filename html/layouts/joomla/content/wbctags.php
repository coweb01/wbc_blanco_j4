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
use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;

$authorised = Factory::getUser()->getAuthorisedViewLevels();

?>
<?php if (!empty($displayData)) : ?>
    <ul class="tags list-inline">
        <?php foreach ($displayData as $i => $tag) : ?>
            <?php if (in_array($tag->access, $authorised)) : ?>
                <li class="list-inline-item tag-<?php echo $tag->tag_id; ?> tag-list<?php echo $i; ?>">
                    <span class="badge badge bg-dark"><?php echo $this->escape($tag->title); ?></span>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
