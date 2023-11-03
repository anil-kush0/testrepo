<?php
 
namespace Drupal\anilweb\Plugin\WebformHandler;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
 
/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "my webform",
 *   label = @Translation("your files"),
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
    $file_field_name = 'your_file';
    if (!empty($webform_submission->getData($file_field_name))) {
      $file = File::load($webform_submission->getData($file_field_name)['your_file']);
    
      if ($file) {
        $file_type = $file->getMimeType();
    
        switch ($file_type) {
          case (strpos($file_type, 'image/') === 0):
            $bundle = 'image';
            break;
          case 'application/pdf':
            $bundle = 'document';
            break;
          case 'audio/mpeg':
            $bundle = 'audio';
            break;
          default:
            $bundle = null;
            break;
        }
    
        if ($bundle) {
          $media = Media::create([
            'bundle' => $bundle,
            'name' => $file->getFilename(),
            'field_media_' . $bundle => [
              'target_id' => $file->id(),
            ],
          ]);
          $media->save();
        }
      }
    }
    
  }
}

