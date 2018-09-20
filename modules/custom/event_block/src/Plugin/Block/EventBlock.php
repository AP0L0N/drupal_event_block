<?php

namespace Drupal\event_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\event_timer\EventTimerService;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "sidebar_event_block",
 *   admin_label = @Translation("Event block"),
 * )
 */
class EventBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {

        $node = \Drupal::request()->attributes->get('node');

        if($node) {

            $timestamp = $node->get('field_event_date')->getValue();
            $date = DrupalDateTime::createFromFormat("Y-m-d\TH:i:s", current(current($timestamp)));
            $markup = $this->t(EventTimerService::getHumanDateDifferenceForEvent($date));
        }

        return [
            '#type' => 'markup',
            '#markup' => $markup ?? "Event details not available",
            '#cache' => [
                'max-age' => 0
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $config = $this->getConfiguration();

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['event_block_settings'] = $form_state->getValue('event_block_settings');
    }
}