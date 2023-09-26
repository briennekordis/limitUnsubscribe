<?php

require_once 'limitunsubscribe.civix.php';
// phpcs:disable
use CRM_Limitunsubscribe_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function limitunsubscribe_civicrm_config(&$config): void {
  _limitunsubscribe_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function limitunsubscribe_civicrm_install(): void {
  _limitunsubscribe_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function limitunsubscribe_civicrm_enable(): void {
  _limitunsubscribe_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function limitunsubscribe_civicrm_preProcess($formName, &$form): void {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function limitunsubscribe_civicrm_navigationMenu(&$menu): void {
//  _limitunsubscribe_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _limitunsubscribe_civix_navigationMenu($menu);
//}

/**
 * Implements hook_civicrm_buildForm().
 *
 * Set a default value for an event price set field.
 *
 * @param string $formName
 * @param CRM_Core_Form $form
 */
function limitunsubscribe_civicrm_buildForm($formName, $form) {
  if ($formName === 'CRM_Mailing_Form_Unsubscribe') {
    $contactMin = 3;
    $groupsArray = $form->getTemplate()->_tpl_vars["groups"];
    $groupTitle = reset($groupsArray)['title'];
    $contactCount = \Civi\Api4\Group::get(FALSE)
      ->addSelect('contact_count')
      ->addWhere('title', '=', $groupTitle)
      ->execute()
      ->first()['contact_count'] ?? 0;
    if ($contactCount <= $contactMin) {
      $form->removeElement('buttons');
    }
  }
}


function limitunsubscribe_civicrm_alterContent(&$content, $context, $tplName, &$object) {
  // Search and replace for the text to change in the .tpl file.
  if($tplName === "CRM/Mailing/Form/Unsubscribe.tpl" && (!isset($object->_elementIndex["buttons"]))) {
    // Hide the status warning on the page for the unsubscribe confirmation.
    $statusDiv = '<div class="messages status no-popup">';
    $alteredStatusDiv = '<div class="messages status no-popup" style="display:none">';
    $content = str_replace($statusDiv, $alteredStatusDiv, $content);
    // Use a combination of string and Regex replacement to remove the unsubscribe confirmation that includes the contact's email address.
    $contentLineBeginning = 'You are requesting to unsubscribe <strong>all email addresses for';
    $contentLineEnding = ' </strong> from the above mailing list.';
    $content = str_replace($contentLineBeginning, '', $content);
    $content = str_replace($contentLineEnding, '', $content);
    // Remove the partially redacted email address from the content line.
    $content = preg_replace('/\s[a-zA-Z]{2}\*+/', '', $content);
    // Change the last of the confirmation to indicate the reason why unsubscribing from the group is not available via CiviCRM.
    $secondContentLine = 'If this is your email address and you <strong>wish to unsubscribe</strong> please click the <strong>Unsubscribe</strong> button to confirm.';
    $newContentLine = 'This mailing group is a Google Group. Please unsubscribe from the Google Group directly.';
    $content = str_replace($secondContentLine, $newContentLine, $content);
  }
}
