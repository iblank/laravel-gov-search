<?php namespace iblank\GovSearch\Facades;
use Illuminate\Support\Facades\Facade;

class GovSearch extends Facade {

	/**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'govsearch'; }
}