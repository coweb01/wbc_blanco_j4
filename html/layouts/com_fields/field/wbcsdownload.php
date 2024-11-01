<?php

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
use Joomla\CMS\Version;


if (!array_key_exists('field', $displayData)) {
    return;
}
$jversion = new Version();
$version = $jversion->getShortVersion();
if (version_compare($version, '5.0', '<')) {
    $iconClass = 'fa-solid fa-file-arrow-down';
} else {
    $iconClass = 'fas fa-file-download';
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
                $content['media_titel'] = trim($subfield->rawvalue);
                break;
            case 'textarea':
                $content['media_beschreibung'] = trim($subfield->rawvalue);
                break;
            case 'mediajce':
                if ($subfield->fieldparams->get('media_target') !== '') {
                    $media_target = $subfield->fieldparams->get('media_target');
                    $content['targetyp'] = 'target="'.trim($media_target).'"';                   
                } else {
                    $content['targetyp'] = '';
                }

                if ( is_array($subfield->rawvalue) )
                {
                    foreach ($subfield->rawvalue as $key => $value) {
                        $content[$key] = trim($value);
                    }
                } else {
                   $content['media_src']     = trim($subfield->rawvalue);
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
   
    // das Feld media_title hat Vorrang vor media_text
    if (isset($content['media_titel']) && !empty($content['media_titel'])) {
        $titel = Text::_('TPL_WBC_BLANCO_DOWNLOAD').$content['media_titel'];
        $content['media_text'] = $content['media_titel'];
    } 

    if (!isset($titel) && isset($content['media_text']) && !empty($content['media_text'])) {
        $titel = Text::_('TPL_WBC_BLANCO_DOWNLOAD').$content['media_text'];
    }
    
    if (!isset($titel)) {
        $titel                    = Text::_('TPL_WBC_BLANCO_DOWNLOAD') .$content['media_text'];
        $lastSlashPos             = strrpos(trim($content['media_src']), '/');
        $content['media_text']    = substr(trim($content['media_src']), $lastSlashPos + 1);
    }

    if (isset($content['media_text']) && $media_target == 'download') {
            $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="'. $iconClass . ' pe-3" aria-hidden="true"></i><a download="'.$content['media_src'].'" href="'. $content['media_src'] .'" title="'.$titel.'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['media_text'] .'</a></span>';
    } else {
        $row_output[0] = '<span class="wbc__file_link d-block pe-3"><i class="'. $iconClass . ' pe-3" aria-hidden="true"></i><a href="'. $content['media_src'] .'" title="'.$titel.'" class="wbc_file" '.$content['targetyp'].' rel="nofollow">'. $content['media_text'] .'</a></span>';
    }

    if (isset($content['media_beschreibung'])) {
         $row_output[1] = '<span class="wbc__file_desc d-block">'. $content['media_beschreibung'] .'</span>';
    }

    $result .= '<div class="wbc__subform-download-row d-md-flex'; 
    $result .= trim($field->params->get('render_class', '')) . '">';
    $result .= implode(' ', $row_output);
    $result .= '</div>';
}
?>

<?php echo $result; ?>