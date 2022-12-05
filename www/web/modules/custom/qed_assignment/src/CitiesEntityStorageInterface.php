<?php

namespace Drupal\qed_assignment;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\qed_assignment\Entity\CitiesEntityInterface;

/**
 * Defines the storage handler class for Cities entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Cities entity entities.
 *
 * @ingroup qed_assignment
 */
interface CitiesEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Cities entity revision IDs for a specific Cities entity.
   *
   * @param \Drupal\qed_assignment\Entity\CitiesEntityInterface $entity
   *   The Cities entity entity.
   *
   * @return int[]
   *   Cities entity revision IDs (in ascending order).
   */
  public function revisionIds(CitiesEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Cities entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Cities entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\qed_assignment\Entity\CitiesEntityInterface $entity
   *   The Cities entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(CitiesEntityInterface $entity);

  /**
   * Unsets the language for all Cities entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
