 <?php
    /* Bootstrap Accordion / Tab
    *  Author: Webconcept
    */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

HTMLHelper::_('bootstrap.tab');

$params            = $displayData->params;
$collapse_first_item = $params->get('collapse_first_item');
$mediapath         = 'media/templates/site/wbc_blanco_j4/';
$item              = $displayData->item;
$htmlausgabe       = $displayData->htmlausgabe;
$i                 = 0;

$wa                = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('accordiontab', $mediapath . 'css/accordiontab.css');

?>
<?php ksort($htmlausgabe); // Array sortieren Feld kontaktdaten immer als erstes ausgeben ! ?>

<?php if ($params->get('layout_customfields') == 0) :   // Accordion ?>
<div class="accordion" id="FieldsAccordion-<?php echo $item->id; ?>">
    <?php foreach ($htmlausgabe as $field) : ?>
        <div class="accordion-item">
            <button class="accordion-button <?php echo $i == 0 && $collapse_first_item == 1 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $field['id'] . '-' . $item->id; ?>" aria-expanded="<?php echo $i == 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $field['id'] . '-' . $item->id; ?>">
                <?php echo $field['headline'] ?>
            </button>
            <div id="collapse<?php echo $field['id'] . '-' . $item->id; ?>" class="accordion-collapse collapse <?php echo $i == 0 && $collapse_first_item == 1 ? 'show' : ''; ?>" data-bs-parent="#FieldsAccordion-<?php echo $item->id; ?>">
            <div class="accordion-body">
                <?php echo $field['content'];?>
            </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
 </div>

<?php else :   // Tabs?>
   
    <ul class="nav nav-tabs" id="FieldsTab-<?php echo $item->id; ?>" role="tablist">
        <?php foreach ($htmlausgabe as $field) : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $i == 0 ? 'active' : ''; ?>" id="tab-<?php echo $field['id'] . '-' . $item->id; ?>" data-bs-toggle="tab" data-bs-target="#tab-pane-<?php echo $field['id'] . '-' . $item->id; ?>" type="button" role="tab" aria-controls="tab-pane-<?php echo $field['id'] . '-' . $item->id; ?>" aria-selected=""><?php echo $field['headline'] ?></button>
            </li>
            <?php $i++; ?>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content" id="FieldsTabContent-<?php echo $item->id; ?>">
    <?php $i = 0; ?>
    <?php foreach ($htmlausgabe as $field) : ?>
        <div class="tab-pane fade <?php echo $i == 0 ? 'active show' : ''; ?>" id="tab-pane-<?php echo $field['id'] . '-' . $item->id; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $field['id'] . '-' . $item->id; ?>" tabindex="0">
            <?php echo $field['content'];?>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
    </div>
   
<?php endif; ?>       