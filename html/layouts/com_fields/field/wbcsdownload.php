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
    $content = [];
    // Iterate over each sub field inside of that row
    foreach ($subform_row as $subfield) {
        $class       = trim($subfield->params->get('render_class', ''));
        $layout      = trim($subfield->params->get('layout', 'render'));
        $fieldtyp    = trim($subfield->type);
        $fieldid     = trim($subfield->id);

        if ($subfield->rawvalue == '') {
            continue;
        }
        
        switch ($fieldtyp) {
          
            case 'text':
                $content['titel'] = trim($subfield->rawvalue);
                break;
            case 'textarea':
                $content['beschreibung'] = trim($subfield->rawvalue);
                break;
            case 'mediajce':
                $content['targetyp'] = trim($subfield->fieldparams->get('media_target'));
                $content['file']     = trim($subfield->rawvalue);
                $lastSlashPos        = strrpos(trim($subfield->rawvalue), '/');
                $content['filename'] = substr(trim($subfield->rawvalue), $lastSlashPos + 1);
                break;
        }
        
    }

     // Skip empty output
    if (count($content) == 0) {
        continue;
    }
    if (!isset($content['file'])) {
        continue;
    }

    if (isset($content['titel']) && $content['targetyp'] == 'download') {
            $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="fas fa-file-download pe-3" aria-hidden="true"></i><a href="'. $content['file'] .'" title="'.Text::_('TPL_WBC_BLANCO_DOWNLOAD').' ' . $content['filename'].'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['titel'] .'</a></span>';
    } else {
        $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="fas fa-file-download pe-3" aria-hidden="true"></i><a href="'. $content['file'] .'" title="'.Text::_('TPL_WBC_BLANCO_DOWNLOAD').' ' . $content['filename'].'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['filename'] .'</a></span>';
    }

    if (isset($content['beschreibung'])) {
         $row_output[1] = '<span class="wbc__file_desc d-block">'. $content['beschreibung'] .'</span>';
    }

    $result .= '<div class="wbc__subform-download-row d-md-flex">' . implode(' ', $row_output) . '</div>';
}
?>

<?php echo $result; ?>