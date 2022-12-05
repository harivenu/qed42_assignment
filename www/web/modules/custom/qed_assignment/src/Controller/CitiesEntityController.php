<?php

namespace Drupal\qed_assignment\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\qed_assignment\Entity\CitiesEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CitiesEntityController.
 *
 *  Returns responses for Cities entity routes.
 */
class CitiesEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Cities entity revision.
   *
   * @param int $cities_entity_revision
   *   The Cities entity revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($cities_entity_revision) {
    $cities_entity = $this->entityTypeManager()->getStorage('cities_entity')
      ->loadRevision($cities_entity_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('cities_entity');

    return $view_builder->view($cities_entity);
  }

  /**
   * Page title callback for a Cities entity revision.
   *
   * @param int $cities_entity_revision
   *   The Cities entity revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($cities_entity_revision) {
    $cities_entity = $this->entityTypeManager()->getStorage('cities_entity')
      ->loadRevision($cities_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $cities_entity->label(),
      '%date' => $this->dateFormatter->format($cities_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Cities entity.
   *
   * @param \Drupal\qed_assignment\Entity\CitiesEntityInterface $cities_entity
   *   A Cities entity object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(CitiesEntityInterface $cities_entity) {
    $account = $this->currentUser();
    $cities_entity_storage = $this->entityTypeManager()->getStorage('cities_entity');

    $langcode = $cities_entity->language()->getId();
    $langname = $cities_entity->language()->getName();
    $languages = $cities_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $cities_entity->label()]) : $this->t('Revisions for %title', ['%title' => $cities_entity->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all cities entity revisions") || $account->hasPermission('administer cities entity entities')));
    $delete_permission = (($account->hasPermission("delete all cities entity revisions") || $account->hasPermission('administer cities entity entities')));

    $rows = [];

    $vids = $cities_entity_storage->revisionIds($cities_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\qed_assignment\Entity\CitiesEntityInterface $revision */
      $revision = $cities_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $cities_entity->getRevisionId()) {
          $link = Link::fromTextAndUrl($date, new Url('entity.cities_entity.revision', [
            'cities_entity' => $cities_entity->id(),
            'cities_entity_revision' => $vid,
          ]))->toString();
        }
        else {
          $link = $cities_entity->toLink($date)->toString();
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.cities_entity.translation_revert', [
                'cities_entity' => $cities_entity->id(),
                'cities_entity_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.cities_entity.revision_revert', [
                'cities_entity' => $cities_entity->id(),
                'cities_entity_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.cities_entity.revision_delete', [
                'cities_entity' => $cities_entity->id(),
                'cities_entity_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['cities_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
