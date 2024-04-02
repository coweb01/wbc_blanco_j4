<?php
    /* Bootstrap Accordion / Tab
    *  Author: Webconcept
    */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('bootstrap.tab');

$params         = $displayData->params;
$mediapath      = 'media/templates/site/wbc_blanco_j4/';

$selectedFields    = $params->get('select_customfield');

$wa             = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('accordiontab', $mediapath . 'css/accordiontab.css');

?>

<?php if ($params->get('layout_customfields') == 0) : ?>
    <div class="accordion" id="FieldsAccordion-<?php echo $displayData->id; ?>">
    <?php foreach ($selectedFields as $index=>$id) : ?>
        <div class="accordion-item">
            <button class="accordion-button <?php echo $index == 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $id . '-' . $displayData->id; ?>" aria-expanded="<?php echo $index == 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $id; ?>">
                <?php echo ($displayData->jcfields[$id]->title); ?>
            </button>
            <div id="collapse<?php echo $id . '-' . $displayData->id; ?>" class="accordion-collapse collapse <?php echo $index == 0 ? 'show' : ''; ?>" data-bs-parent="#FieldsAccordion-<?php echo $displayData->id; ?>">
            <div class="accordion-body">
                <p><?php echo ($displayData->jcfields[$id]->value); ?></p>
            </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

<?php else : ?>
    <ul class="nav nav-tabs" id="FieldsTab-<?php echo $displayData->id; ?>" role="tablist">
        <?php foreach ($selectedFields as $index=>$id) : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $index == 0 ? 'active' : ''; ?>" id="tab-<?php echo $id . '-' . $displayData->id; ?>" data-bs-toggle="tab" data-bs-target="#tab-pane-<?php echo $id . '-' . $displayData->id; ?>" type="button" role="tab" aria-controls="tab-pane-<?php echo $id . '-' . $displayData->id; ?>" aria-selected=""><?php echo ($displayData->jcfields[$id]->title); ?></button>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content" id="FieldsTabContent-<?php echo $displayData->id; ?>">
    <?php foreach ($selectedFields as $index=>$id) : ?>
        <div class="tab-pane fade <?php echo $index == 0 ? 'active show' : ''; ?>" id="tab-pane-<?php echo $id . '-' . $displayData->id; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $id . '-' . $displayData->id; ?>" tabindex="0">
            <p><?php echo ($displayData->jcfields[$id]->value); ?></p>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
