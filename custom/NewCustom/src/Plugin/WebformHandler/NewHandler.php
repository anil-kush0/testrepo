<?php
 
namespace Drupal\assignment\Plugin\WebformHandler;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
 
/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "new id",
 *   label = @Translation("media adding"),
 *   category = @Translation("Entity Creation"),
 *   description = @Translation("Creates a new node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
 
class NewHandler extends WebformHandlerBase {
  
  /**
   * {@inheritdoc}
   */
 
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $file_field_name = 'your_attachment'; 
    if (!empty($webform_submission->getData($file_field_name))) {
      $file = File::load($webform_submission->getData($file_field_name)['your_attachment']);

      if ($file) {
        $file_type = $file->getMimeType();

        if (strpos($file_type, 'image/') === 0) {
          $media = Media::create([
            'bundle' => 'image',
            'name' => $file->getFilename(),
            'field_media_image' => [
                'target_id' => $file->id(),
            ],
        ]);
        $media->save();
        }
        else if ($file_type === 'application/pdf') {
          $media = Media::create([
            'bundle' => 'document',
            'name' => $file->getFilename(),
            'field_media_document' => [
                'target_id' => $file->id(),
            ],
        ]);
        $media->save();
        } 
      }
    }
  }
}


