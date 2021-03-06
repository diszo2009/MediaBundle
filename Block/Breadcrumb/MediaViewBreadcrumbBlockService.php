<?php

namespace Rz\MediaBundle\Block\Breadcrumb;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Knp\Menu\FactoryInterface;
use Sonata\MediaBundle\Block\Breadcrumb\MediaViewBreadcrumbBlockService as BaseMediaViewBreadcrumbBlockService;

/**
 * BlockService for view Media.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class MediaViewBreadcrumbBlockService extends BaseMediaViewBreadcrumbBlockService
{
    /**
     * @var string
     */
    private $context;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param string                $context
     * @param string                $name
     * @param EngineInterface       $templating
     * @param MenuProviderInterface $menuProvider
     * @param FactoryInterface      $factory
     */
    public function __construct($context, $name, EngineInterface $templating, MenuProviderInterface $menuProvider, FactoryInterface $factory)
    {
        parent::__construct($context, $name, $templating, $menuProvider, $factory);

        $this->context = $context;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata.media.block.breadcrumb_view_media';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = $this->getRootMenu($blockContext);

        if ($media = $blockContext->getBlock()->getSetting('media')) {
            $menu->addChild($media->getName(), array(
                'route'           => 'sonata_media_view',
                'routeParameters' => array(
                    'id' => $media->getId(),
                ),
            ));
        }

        return $menu;
    }

    /**
     * Initialize breadcrumb menu.
     *
     * @param BlockContextInterface $blockContext
     *
     * @return ItemInterface
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $settings = $blockContext->getSettings();
        /*
         * @todo : Use the router to get the homepage URI
         */

        $menu = $this->factory->createItem('breadcrumb');

        $menu->setChildrenAttribute('class', 'breadcrumb');
        $menu->setCurrent($settings['current_uri']);

        if ($settings['include_homepage_link']) {
            $menu->addChild('sonata_seo_homepage_breadcrumb', array('uri' => '/'));
        }

        return $menu;
    }
}
