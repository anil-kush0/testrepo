<?php
 
namespace Drupal\assignment\Plugin\WebformHandler;
 
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
 *   label = @Translation("Create a node"),
 *   category = @Translation("Entity Creation"),
 *   description = @Translation("Creates a new node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
 
class CreateNodeWebformHandler extends WebformHandlerBase {
  
  /**
   * {@inheritdoc}
   */
 
  // Function to be fired after submitting the Webform.
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $file_field_name = 'your_attachment'; 
    if (!empty($webform_submission->getData($file_field_name))) {
      $file = File::load($webform_submission->getData($file_field_name)['your_attachment']);

      
      if ($file) {
        // to get the mime type of field media
        $file_type = $file->getMimeType();
        // dd($file_type);
        if (strpos($file_type, 'video/') === 0) {
        $video_media = Media::create([
          'bundle' => 'video',
          'uid' => 1,
          'name' => 'anil video',
          'field_media_video_file' => [
                'target_id' => $file->id(),
            ],
        ]);
        $video_media->save();
        }
        else if (strpos($file_type, 'image/') === 0) {
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
        
      
        else {
          // dd("working anil ");
        }
      }
    }
  }


}


