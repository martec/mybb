<?php

namespace MyBB\Twig;

use DB_Base;
use Illuminate\Contracts\Container\Container;
use MyBB;
use MyBB\Twig\Extensions\CoreExtension;
use MyBB\Twig\Extensions\LangExtension;
use MyBB\Twig\Extensions\ThemeExtension;
use MyBB\Twig\Extensions\UrlExtension;
use MyBB\Utilities\BreadcrumbManager;
use MyLanguage;
use pluginSystem;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class DatabaseTwigLoader implements \Twig\Loader\LoaderInterface
{

    public function getSourceContext(string $name): \Twig\Source
    {
        if (false === $source = $this->getValue('template', $name)) {
            throw new \Twig\Error\LoaderError(sprintf('Template "%s" does not exist.', $name));
        }

        return new \Twig\Source($source, $name);
    }

    public function exists(string $name)
    {
        return $name === $this->getValue('title', $name).'_'.$GLOBALS['theme']['templateset'];
    }

    public function getCacheKey(string $name): string
    {
        return $name.'_'.$GLOBALS['theme']['templateset'];
    }

    public function isFresh(string $name, int $time): bool
    {
        if (false === $lastModified = $this->getValue('dateline', $name)) {
            return false;
        }

        return $lastModified <= $time;
    }

    protected function getValue($var, $name)
    {
		// Only load master and global templates if template is needed in Admin CP
		if(empty($GLOBALS['theme']['templateset']))
		{
			$query = $GLOBALS['db']->simple_select("templates", "template,title,dateline", "title='".$GLOBALS['db']->escape_string($name)."'");
		}
		else
		{
			$query = $GLOBALS['db']->simple_select("templates", "template,title,dateline", "title='".$GLOBALS['db']->escape_string($name)."' AND sid IN ('-2','-1','".(int)$GLOBALS['theme']['templateset']."')", array('order_by' => 'sid', 'order_dir' => 'DESC', 'limit' => 1));
		}
		
		$gettemplate = $GLOBALS['db']->fetch_array($query);

		if(!$gettemplate)
		{
			$gettemplate[$var] = "";
		}

        return $gettemplate[$var];
    }
}

/** @property \MyBB\Application $app */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind(CoreExtension::class, function (Container $container) {
            return new CoreExtension(
                $container->make(MyBB::class),
                $container->make(MyLanguage::class),
                $container->make(pluginSystem::class),
                $container->make(BreadcrumbManager::class)
            );
        });

        $this->app->bind(ThemeExtension::class, function (Container $container) {
            return new ThemeExtension(
                $container->make(MyBB::class),
                $container->make(DB_Base::class)
            ) ;
        });

        $this->app->bind(LangExtension::class, function (Container $container) {
            return new LangExtension(
                $container->make(MyLanguage::class)
            );
        });

        $this->app->bind(UrlExtension::class, function () {
            return new UrlExtension();
        });

        $this->app->bind(LoaderInterface::class, function () {
            return new DatabaseTwigLoader();
        });

        $this->app->bind('twig.options', function () {
            return [
                'debug' => true, // TODO: In live environments this should be false
                'cache' => __DIR__ . '/../../../cache/views',
            ];
        });

        $this->app->bind(Environment::class, function (Container $container) {
            $env = new Environment(
                $container->make(LoaderInterface::class),
                $container->make('twig.options')
            );

            $env->addExtension($container->make(CoreExtension::class));
            $env->addExtension($container->make(ThemeExtension::class));
            $env->addExtension($container->make(LangExtension::class));
            $env->addExtension($container->make(UrlExtension::class));

            // TODO: this shouldn't be registered in live environments
            $env->addExtension(new DebugExtension());

            return $env;
        });
    }

    public function provides()
    {
        return [
            CoreExtension::class,
            ThemeExtension::class,
            LangExtension::class,
            UrlExtension::class,
            LoaderInterface::class,
        ];
    }
}
