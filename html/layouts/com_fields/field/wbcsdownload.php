﻿<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Override fuer Feld Subform. Verwendung für Downloadfelder als Subform.
 * Ausgabe der Felder Typ:
 * textarea feld = Beschreibung, 
 * media für die Datei = url und titel
 * text für den Titel  = titel ( kann auch weggelassen werden )
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;


if (!array_key_exists('field', $displayData)) {
    return;
}
$jversion = new JVersion();
$version = $jversion->getShortVersion();
if (version_compare($version, '5.0', '<')) {
    $iconClass = 'fa-solid fa-file-arrow-down';
} else {
    $iconClass = 'fas fa-file-download';
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
                $content['media_text'] = trim($subfield->rawvalue);
                break;
            case 'textarea':
                $content['media_beschreibung'] = trim($subfield->rawvalue);
                break;
            case 'mediajce':
                $content['targetyp'] = trim($subfield->fieldparams->get('media_target'));
                if ( is_array($subfield->rawvalue) )
                {
                    foreach ($subfield->rawvalue as $key => $value) {
                        $content[$key] = trim($value);
                    }
                } else {
                   $content['media_src']     = trim($subfield->rawvalue);
                   $lastSlashPos             = strrpos(trim($subfield->rawvalue), '/');
                   $content['media_text']    = substr(trim($subfield->rawvalue), $lastSlashPos + 1);
                }
                
                
                break;
        }
        
    }

     // Skip empty output
    if (count($content) == 0) {
        continue;
    }
    if (!isset($content['media_src'])) {
        continue;
    }

    if (isset($content['media_text']) && $content['targetyp'] == 'download') {
            $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="'. $iconClass . ' pe-3" aria-hidden="true"></i><a href="'. $content['media_src'] .'" title="'.Text::_('TPL_WBC_BLANCO_DOWNLOAD').' ' . $content['media_text'].'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['media_text'] .'</a></span>';
    } else {
        $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="'. $iconClass . ' pe-3" aria-hidden="true"></i><a href="'. $content['media_src'] .'" title="'.Text::_('TPL_WBC_BLANCO_DOWNLOAD').' ' . $content['media_text'].'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['media_text'] .'</a></span>';
    }

    if (isset($content['media_beschreibung'])) {
         $row_output[1] = '<span class="wbc__file_desc d-block">'. $content['media_beschreibung'] .'</span>';
    }

    $result .= '<div class="wbc__subform-download-row d-md-flex">' . implode(' ', $row_output) . '</div>';
}
?>

<?php echo $result; ?>