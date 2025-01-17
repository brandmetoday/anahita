<?php

/**
 * {@inheritdoc}
 *
 * @category   Anahita
 *
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.Anahita.io
 */
class ComMediumDomainBehaviorPrivatable extends LibBaseDomainBehaviorPrivatable
{
    /**
     * {@inheritdoc}
     */
    protected function _beforeRepositoryFetch(AnCommandContext $context)
    {
        $viewer = $this->getService('com:people.viewer');
        
        if ($viewer->admin()) {
            return;
        }

        $query = $context->query;
        $repository = $query->getRepository();
        $config = pick($query->privacy, new AnConfig());

        $config->append(array(
            'viewer' => $viewer,
            'graph_check' => true,
        ));

        if ($repository->hasBehavior('ownable')) {
            //do a left join operation just in case an owner is missing
            $query->link('owner', array('type' => 'weak', 'bind_type' => false));
            $config->append(array(
               'use_access_column' => '@col(access)',
            ));
            $c1 = $this->buildCondition('@col(owner.id)', $config, '@col(owner.access)');
            $c2 = $this->buildCondition('@col(owner.id)', $config, $config->use_access_column);
            $where = "IF($c1, $c2, 0)";
            $query->where($where);
        }
    }
}
