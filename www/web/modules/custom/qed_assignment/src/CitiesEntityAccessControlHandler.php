<?php

namespace Drupal\qed_assignment;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Cities entity entity.
 *
 * @see \Drupal\qed_assignment\Entity\CitiesEntity.
 */
class CitiesEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\qed_assignment\Entity\CitiesEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished cities entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published cities entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit cities entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete cities entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add cities entity entities');
  }


}
