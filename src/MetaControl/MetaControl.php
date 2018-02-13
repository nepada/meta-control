<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;

use Nette;
use Nette\Utils\Html;


class MetaControl extends Nette\Application\UI\Component
{

    private const META_AUTHOR = 'author';
    private const META_DESCRIPTION = 'description';
    private const META_KEYWORDS = 'keywords';
    private const META_ROBOTS = 'robots';

    /** @var string|null */
    private $charset;

    /** @var string[] */
    private $metadata = [];

    /** @var string[] */
    private $properties = [];

    /** @var string[] */
    private $pragmas = [];


    public function render(): void
    {
        if ($this->charset !== null) {
            echo Html::el('meta', ['charset' => $this->charset]) . "\n";
        }
        foreach ($this->metadata as $name => $content) {
            echo Html::el('meta', ['name' => $name, 'content' => $content]) . "\n";
        }
        foreach ($this->properties as $name => $content) {
            echo Html::el('meta', ['property' => $name, 'content' => $content]) . "\n";
        }
        foreach ($this->pragmas as $httpEquiv => $content) {
            echo Html::el('meta', ['http-equiv' => $httpEquiv, 'content' => $content]) . "\n";
        }
    }

    /**
     * @return string|null
     */
    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * @param string|null $charset
     */
    public function setCharset(?string $charset): void
    {
        $this->charset = $charset;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getMetadata(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->metadata, $name, null);
    }

    /**
     * @param string $name
     * @param string|null $content
     */
    public function setMetadata(string $name, ?string $content): void
    {
        if ($content === null) {
            unset($this->metadata[$name]);
        } else {
            $this->metadata[$name] = $content;
        }
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getProperty(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->properties, $name, null);
    }

    /**
     * @param string $property
     * @param string|null $content
     */
    public function setProperty(string $property, ?string $content): void
    {
        if ($content === null) {
            unset($this->properties[$property]);
        } else {
            $this->properties[$property] = $content;
        }
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getPragma(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->pragmas, $name, null);
    }

    /**
     * @param string $httpEquiv
     * @param string|null $content
     */
    public function setPragma(string $httpEquiv, ?string $content): void
    {
        if ($content === null) {
            unset($this->pragmas[$httpEquiv]);
        } else {
            $this->pragmas[$httpEquiv] = $content;
        }
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->getMetadata(self::META_AUTHOR);
    }

    /**
     * @param string|null $author
     */
    public function setAuthor(?string $author): void
    {
        $this->setMetadata(self::META_AUTHOR, $author);
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getMetadata(self::META_DESCRIPTION);
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->setMetadata(self::META_DESCRIPTION, $description);
    }

    /**
     * @return string[]
     */
    public function getKeywords(): array
    {
        $keywords = $this->getMetadata(self::META_KEYWORDS);
        return $keywords === null ? [] : array_map('trim', explode(',', $keywords));
    }

    /**
     * @param string[] ...$keywords
     */
    public function setKeywords(string ...$keywords): void
    {
        if ($keywords === []) {
            $this->setMetadata(self::META_KEYWORDS, null);
        } else {
            $keywords = array_map('trim', $keywords);
            $keywords = array_unique($keywords);
            $this->setMetadata(self::META_KEYWORDS, implode(', ', $keywords));
        }
    }

    /**
     * @param string $keyword
     */
    public function addKeyword(string $keyword): void
    {
        $keywords = $this->getKeywords();
        $keywords[] = $keyword;
        $this->setKeywords(...$keywords);
    }

    /**
     * @return string|null
     */
    public function getRobots(): ?string
    {
        return $this->getMetadata(self::META_ROBOTS);
    }

    /**
     * @param string|null $robots
     */
    public function setRobots(?string $robots): void
    {
        $this->setMetadata(self::META_ROBOTS, $robots);
    }

}
