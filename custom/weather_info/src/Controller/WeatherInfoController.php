<?php

namespace Drupal\weather_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

/**
 * Controller to fetch and display weather information based on the user's IP.
 */
class WeatherInfoController extends ControllerBase {
  /**
   * The configuration object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a WeatherInfoController object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory service.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Returns weather information based on the user's IP.
   */
  public function weatherInfo(Request $request) {
    $config = $this->configFactory->get('weather_info.settings');
    $apiUrl = $config->get('api_url');
    $apiKey = $config->get('api_key');

    // Fetch the user's IP address.
    $ip = $request->getClientIp();

    // Make a request to the OpenWeather API using Guzzle HTTP client.
    $client = \Drupal::httpClient();
    $response = $client->get($apiUrl, [
      'query' => [
        'q' => $ip,
        'appid' => $apiKey,
      ],
    ]);

    $data = json_decode($response->getBody());

    $temperature = $data->main->temp;
    $city = $data->name;

    return new JsonResponse([
      'temperature' => $temperature,
      'city' => $city,
    ]);
  }
}
