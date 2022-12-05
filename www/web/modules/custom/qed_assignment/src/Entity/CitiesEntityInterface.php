<?php

namespace Drupal\qed_assignment\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Cities entity entities.
 *
 * @ingroup qed_assignment
 */
interface CitiesEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Cities entity name.
   *
   * @return string
   *   Name of the Cities entity.
   */
  public function getName();

  /**
   * Sets the Cities entity name.
   *
   * @param string $name
   *   The Cities entity name.
   *
   * @return \Drupal\qed_assignment\Entity\CitiesEntityInterface
   *   The called Cities entity entity.
   */
  public function setName($name);

  /**
   * Gets the Cities entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Cities entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Cities entity creation timestamp.
   *
   * @param int $timestamp
   *   The Cities entity creation timestamp.
   *
   * @return \Drupal\qed_assignment\Entity\CitiesEntityInterface
   *   The called Cities entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Cities entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Cities entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\qed_assignment\Entity\CitiesEntityInterface
   *   The called Cities entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Cities entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Cities entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\qed_assignment\Entity\CitiesEntityInterface
   *   The called Cities entity entity.
   */
  public function setRevisionUserId($uid);

}
