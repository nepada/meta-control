<?php
declare(strict_types = 1);

namespace NepadaTests\MetaControl;

use Nepada;
use Nepada\MetaControl\MetaControl;
use Tester;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class MetaControlTest extends Tester\TestCase
{

    public function testCharset(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getCharset());
        Assert::same('', $this->getRenderingOutput($control));

        $control->setCharset('utf-8');
        Assert::same('utf-8', $control->getCharset());
        Assert::same("<meta charset=\"utf-8\">\n", $this->getRenderingOutput($control));

        $control->setCharset(null);
        Assert::same(null, $control->getCharset());
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testMetadata(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getMetadata('author'));
        Assert::same(null, $control->getMetadata('description'));
        Assert::same('', $this->getRenderingOutput($control));

        $control->setMetadata('author', 'Jon Doe');
        $control->setMetadata('description', 'Lorem ipsum');
        Assert::same('Jon Doe', $control->getMetadata('author'));
        Assert::same('Lorem ipsum', $control->getMetadata('description'));
        Assert::same(
            "<meta name=\"author\" content=\"Jon Doe\">\n<meta name=\"description\" content=\"Lorem ipsum\">\n",
            $this->getRenderingOutput($control)
        );

        $control->setMetadata('author', null);
        $control->setMetadata('description', null);
        Assert::same(null, $control->getMetadata('author'));
        Assert::same(null, $control->getMetadata('description'));
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testProperty(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getProperty('og:title'));
        Assert::same(null, $control->getProperty('og:url'));
        Assert::same('', $this->getRenderingOutput($control));

        $control->setProperty('og:title', 'Foo title');
        $control->setProperty('og:url', 'https://example.com');
        Assert::same('Foo title', $control->getProperty('og:title'));
        Assert::same('https://example.com', $control->getProperty('og:url'));
        Assert::same(
            "<meta property=\"og:title\" content=\"Foo title\">\n<meta property=\"og:url\" content=\"https://example.com\">\n",
            $this->getRenderingOutput($control)
        );

        $control->setProperty('og:title', null);
        $control->setProperty('og:url', null);
        Assert::same(null, $control->getProperty('og:title'));
        Assert::same(null, $control->getProperty('og:url'));
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testPragma(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getPragma('content-type'));
        Assert::same(null, $control->getPragma('refresh'));
        Assert::same('', $this->getRenderingOutput($control));

        $control->setPragma('content-type', 'text/html; charset=UTF-8');
        $control->setPragma('refresh', '42');
        Assert::same('text/html; charset=UTF-8', $control->getPragma('content-type'));
        Assert::same('42', $control->getPragma('refresh'));
        Assert::same(
            "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">\n<meta http-equiv=\"refresh\" content=\"42\">\n",
            $this->getRenderingOutput($control)
        );

        $control->setPragma('content-type', null);
        $control->setPragma('refresh', null);
        Assert::same(null, $control->getPragma('content-type'));
        Assert::same(null, $control->getPragma('refresh'));
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testAuthor(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getAuthor());
        Assert::same('', $this->getRenderingOutput($control));

        $control->setAuthor('Jon Doe');
        Assert::same('Jon Doe', $control->getAuthor());
        Assert::same("<meta name=\"author\" content=\"Jon Doe\">\n", $this->getRenderingOutput($control));

        $control->setAuthor(null);
        Assert::same(null, $control->getAuthor());
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testDescription(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getDescription());
        Assert::same('', $this->getRenderingOutput($control));

        $control->setDescription('Foo description');
        Assert::same('Foo description', $control->getDescription());
        Assert::same("<meta name=\"description\" content=\"Foo description\">\n", $this->getRenderingOutput($control));

        $control->setDescription(null);
        Assert::same(null, $control->getDescription());
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testKeywords(): void
    {
        $control = new MetaControl;

        Assert::same([], $control->getKeywords());
        Assert::same('', $this->getRenderingOutput($control));

        $control->setKeywords('foo', 'bar');
        $control->addKeyword('baz');
        $control->addKeyword(' bar ');
        Assert::same(['foo', 'bar', 'baz'], $control->getKeywords());
        Assert::same("<meta name=\"keywords\" content=\"foo, bar, baz\">\n", $this->getRenderingOutput($control));

        $control->setKeywords();
        Assert::same([], $control->getKeywords());
        Assert::same('', $this->getRenderingOutput($control));
    }

    public function testRobots(): void
    {
        $control = new MetaControl;

        Assert::same(null, $control->getRobots());
        Assert::same('', $this->getRenderingOutput($control));

        $control->setRobots('noindex, nofollow');
        Assert::same('noindex, nofollow', $control->getRobots());
        Assert::same("<meta name=\"robots\" content=\"noindex, nofollow\">\n", $this->getRenderingOutput($control));

        $control->setRobots(null);
        Assert::same(null, $control->getRobots());
        Assert::same('', $this->getRenderingOutput($control));
    }

    /**
     * @param MetaControl $control
     * @return string
     */
    private function getRenderingOutput(MetaControl $control): string
    {
        ob_start();
        $control->render();
        return ob_get_clean();
    }

}


(new MetaControlTest())->run();
