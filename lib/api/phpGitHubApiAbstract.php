<?php

/**
 * Abstract class for phpGitHubApi classes
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
abstract class phpGitHubApiAbstract
{
  /**
   * The core API
   * @var phpGitHubApi
   */
  protected $api;

  public function __construct(phpGitHubApi $api)
  {
    $this->api = $api;
  }
}