<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Override fuer Feld Subform.
 * Ausgabe der Felder Typ:
 * uri, text, textarea, editor, acfurl
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

        // Generate the output for this sub field and row
        $row_output[] = '<div class="wbc__field-entry-'.  $fieldtyp . ' ' . ($class ? (' ' . $class) : '') . '">' . $content . '</div>';
    }

    // Skip empty rows
    if (count($row_output) == 0) {
        continue;
    }

    $result .= '<div class="wbc__subform-row">' . implode(' ', $row_output) . '</div>';
}
?>

<?php if (trim($result) != '') : ?>
    <div class="wbc__subform-fields mb-3">
        <?php echo $result; ?>
</div>
<?php endif; ?>
