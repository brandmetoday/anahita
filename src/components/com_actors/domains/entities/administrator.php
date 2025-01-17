<?php

/**
 * Administrator Edge.
 *
 * @category   Anahita
 *
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.Anahita.io
 */
class ComActorsDomainEntityAdministrator extends ComBaseDomainEntityEdge
{
    /**
     * Initializes the default configuration for the object.
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param AnConfig $config An optional AnConfig object with configuration options.
     */
    protected function _initialize(AnConfig $config)
    {
        $config->append(array(
            'relationships' => array(
                'administrator' => array('parent' => 'com:people.domain.entity.person'),
                'administrable' => array('parent' => 'com:actors.domain.entity.actor'),
            ),
            'aliases' => array(
                'administrator' => 'nodeA',
                'administrable' => 'nodeB',
            ),
        ));

        parent::_initialize($config);
    }

    /**
     * Resets the votable stats.
     *
     * AnCommandContext $context Context
     */
    protected function _afterEntityInsert(AnCommandContext $context)
    {
        $this->administrable->getRepository()
                            ->getBehavior('administrable')
                            ->resetStats(array(
                              $this->administrable,
                              $this->administrator, ));
    }

    /**
     * Resets the votable stats.
     */
    protected function _afterEntityDelete(AnCommandContext $context)
    {
        $this->administrable->getRepository()
                            ->getBehavior('administrable')
                            ->resetStats(array(
                              $this->administrable,
                              $this->administrator, ));
    }
}
