<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Override fuer Feld Subform.
 * Ausgabe der Felder als Accordion nur txt und textarea
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;


if (!array_key_exists('field', $displayData)) {
    return;
}
$field = $displayData['field'];

$result = '';
$context = $field->context;

if (!isset($field->subform_rows)) {
    return;
}
// Iterate over each row that we have
foreach ($field->subform_rows as $subform_row) {
    // Placeholder array to generate this rows output
    $row_output = [];

    // Iterate over each sub field inside of that row
    foreach ($subform_row as $subfield) {
        $class       = trim($subfield->params->get('render_class', ''));
        $layout      = trim($subfield->params->get('layout', 'render'));
        $fieldtyp    = trim($subfield->type);
        $fieldid     = trim($subfield->id);
        $content = trim(
            FieldsHelper::render(
                $context,
                'field.' . $layout, // normally just 'field.render'
                ['field' => $subfield]
            )
        );

        // Skip empty output
        if ($content === '') {
            continue;
        }
        // Nur Text und Textarea anzeigen
        if ($fieldtyp != 'text' && $fieldtyp != 'textarea' && $fieldtyp != 'editor') {
            continue;
        }

        // Generate the output for this sub field and row
        $row_output[] = '<div class="wbc__accordion-items accordion-item">';
        $row_output[] = '<h4 class="accordion-header" id="heading-' . $subfield->id . '">';
        $row_output[] = '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $subfield->id . '" aria-expanded="true" aria-controls="collapse-' . $subfield->id . '">' . $subfield->label . '</button></h4>';
        $row_output[] = '<div id="collapse-' . $subfield->id . '" class="accordion-collapse collapse" aria-labelledby="heading-' . $subfield->id . '">';
        $row_output[] = '<div class="accordion-body">' . $subfield->value . '</div></div></div>';
    }

    // Skip empty rows
    if (count($row_output) == 0) {
        continue;
    }

    $result .=  implode(' ', $row_output) ;
}
?>

<?php if (trim($result) != '') : ?>
    <div id="fieldId-<?php echo $field->id;?>" class="wbc__subform-accordion accordion accordion-flush <?php echo trim($field->params->get('render_class', ''));?>">
        <?php echo $result; ?>
    </div>
<?php endif; ?>
