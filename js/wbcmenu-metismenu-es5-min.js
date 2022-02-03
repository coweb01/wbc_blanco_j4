!function(){"use strict";
/**
   * @package     Joomla.Site
   * @subpackage  Templates.cassiopeia
   * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
   * @license     GNU General Public License version 2 or later; see LICENSE.txt
   * @since       4.0.0
   */document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll("ul.mod-menu_wbcdropdown-metismenu").forEach((function(e){var n=new MetisMenu(e,{triggerElement:"button.mm-toggler"}).on("shown.metisMenu",(function(e){window.addEventListener("click",(function t(o){e.target.contains(o.target)||(n.hide(e.detail.shownElement),window.removeEventListener("click",t))}))}))}))}))}();