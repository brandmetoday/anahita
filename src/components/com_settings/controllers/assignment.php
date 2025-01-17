<?php

/**
 * Actor Settings Controller.
 *
 * @category   Anahita
 *
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008-2016 rmd Studio Inc.
 * @license    GNU GPLv3
 *
 * @link       http://www.Anahita.io
 */

class ComSettingsControllerAssignment extends ComBaseControllerResource
{
    private $_components = array();
    
    protected function _actionBrowse(AnCommandContext $context)
    {
        $this->_fetchComponents($context); 
        $actors = $this->_getActors();
        $apps = $this->_getApps();
        
        $this->getView()
        ->set('actors', $actors)
        ->set('apps', $apps);                  
    }

    protected function _actionEdit(AnCommandContext $context)
    {
      $data = $context->data;

      if ($app = $this->getService('repos:components.component')->fetch(array('id' => $data->app))) {
          $app->setAssignmentForIdentifier($data->actor, $data->access);
          $app->save();
          
          $this->_fetchComponents($context);
          $apps = $this->_getApps();
          
          $actor = new AnServiceIdentifier($data->actor);
          
          $content = $this->getView()
          ->set('actor', $actor)
          ->set('apps', $apps)
          ->display(); 
          
          $context->response->setContent($content);
      }
      
      return;
    }
    
    private function _getApps()
    {
        $apps = array();
        
        if (count($this->_components)) {
            foreach($this->_components as $component) {
                if ($component->isAssignable()) {
                   $apps[] = $component;
                }
            }
        }
        
        return $apps;
    }
    
    private function _getActors()
    {
        $actors = array();
        
        if (count($this->_components)) {
            foreach($this->_components as $component) {
              $identifiers = $component->getEntityIdentifiers('ComActorsDomainEntityActor');
              
              foreach ($identifiers as $identifier) {
                  $identifier->application = null;
                  $actors[] = $identifier;
              }
            }
        }
        
        return $actors;
    }
    
    private function _fetchComponents(AnCommandContext $context)
    {
        if (count($this->_components) === 0) {
            $this->_components = $this->getService('repos:components.component')
                               ->getQuery()
                               ->enabled(true)
                               ->order('name')
                               ->fetchSet();
        }
        
        return $this->_components;
    }
}
